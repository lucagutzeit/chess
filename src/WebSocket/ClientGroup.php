<?php

$null = NULL;

abstract class ClientGroup
{
    // Array with clients in group
    private $clientSockets;

    // Identification string of group
    private $id;

    /**
     * Constructor
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->clientSockets = array();
        $this->id = $id;
    }

    /**
     * 
     */
    public function update()
    {
        $changed = $this->getReadableSockets();
        if (!empty($changed)) {
            foreach ($changed as $socket) {
                $msg = $this->readMessage($socket);
                if ($msg != false) {
                    $msg->unmask();
                    switch ($msg->getOpcode()) {
                        case '8':
                            $this->removeClient($socket);
                            break;
                        default:
                            $this->sendToAll($msg);
                            break;
                    }
                }
            }
        }
    }

    /**
     * Getter for id.
     * @return string id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Adds the Websocket $socket to $clients.
     * @param resource $socket WebSocket to add.
     */
    public function addClient($socket)
    {
        $this->clientSockets[] = $socket;
        printf("New Client added to %s.\n", $this->id);
        printf("List of Clients: %s\n", implode(', ', $this->clientSockets));
    }

    /**
     * Removes client from client list.
     * @param WebSocket $socket Socket that need to be removed.
     * @return bool Returns true if client has been removed. False if no such socket could be found.
     */
    public function removeClient($socket)
    {
        if (($key = array_search($socket, $this->clientSockets)) !== false) {
            socket_close($socket);
            unset($this->clientSockets[$key]);
            return true;
        } else {
            printf("No such socket.\n");
            return false;
        }
    }

    /**
     * Getter for clientSockets.
     * @return array clientSockets
     */
    public function getClientSockets()
    {
        return $this->clientSockets;
    }

    /**
     * Get the number of connected clients.
     * @return int Returns the number of connected clients.
     */
    public function clientCount()
    {
        return sizeof($this->clientSockets);
    }

    /**
     * Reads the message on the socket and converts it to a message object.
     * @param WebSocket $socket Socket to read from.
     * @return Message|false returns a new Message object or false if there is no new message on the socket.
     */
    public function readMessage($socket)
    {
        while (socket_recv($socket, $buf, 1024, 0) >= 1) {
            $receivedMsg = new Message();
            $receivedMsg->setMaskedMessage($buf);
            return $receivedMsg;
        }
        return false;
    }

    /**
     * Send a message to all clients in the group.
     * @param Message $msg A message that can be masked.
     */
    public function sendToAll(Message $msg)
    {
        $msg->mask();
        $maskedMessage = $msg->getMaskedMessage();
        foreach ($this->getClientSockets() as $client) {
            if (!socket_write($client, $maskedMessage, strlen($maskedMessage))) {
                printf("Error:\n%s", socket_strerror(socket_last_error()));
            }
        }
    }

    /**
     * Get all readable sockets.
     * @return array Returns an array with all sockets that can be read.
     */
    public function getReadableSockets()
    {
        $changed = $this->clientSockets;
        if (!empty($changed)) {
            socket_select($changed, $null, $null, 0);
            return  $changed;
        } else {
            return array();
        }
    }

    /** 
     * Send a error message at one socket.
     * @param WebSocket Socket which the error should be send to.
     * @param string Description of the error
     */
    public function sendError($socket, string $errorMsg)
    {
        $msg = new Message();
        $arr['type'] = 'error';
        $arr['description'] = $errorMsg;
        $msg->setUnmaskedMessage(json_encode($arr));
        $msg->mask();
        $maskedMessage = $msg->getMaskedMessage();
        if (!socket_write(array_pop($socket), $maskedMessage, strlen($maskedMessage))) {
            printf("Error:\n%s", socket_strerror(socket_last_error()));
        } else {
            printf("Send to %s\n", $socket);
        }
    }
}
