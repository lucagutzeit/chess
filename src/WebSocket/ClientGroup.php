<?php
require 'MessageHandler.php';

$null = NULL;

abstract class ClientGroup
{
    // Array with clients in group
    private $clientSockets;

    // Identification string of group
    private $id;

    /**
     * Constructor
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function update()
    {
        $changed = $this->getReadableSockets();
        if (!empty($changed)) {
            foreach ($changed as $socket) {
                $msg = $this->receiveMessage($socket);
                if ($msg != false) {
                    $this->sendToAll($msg);
                }
            }
        }
    }

    /**
     * Adds the Websocket $socket to $clients.
     * @param resource $socket WebSocket to add.
     */
    public function addClient($socket)
    {
        $this->clientSockets[] = $socket;
        printf("New Client added to %s.\n", $this->id);
        printf("List of Clients: %s", implode(', ', $this->clientSockets) . "\n");
    }

    /**
     * 
     */
    public function removeClient($socket)
    {
        if (($key = array_search($socket, $this->clientSockets)) != false) {
            unset($this->clientSockets[$key]);
        }
    }


    /**
     * 
     */
    public function receiveMessage($socket)
    {
        if (socket_recv($socket, $buf, 1024, 0) >= 1) {
            $receivedMsg = MessageHandler::unmask($buf);
            return $receivedMsg;
        }
        return false;
    }

    public function sendToAll($msg)
    {
        $msg = MessageHandler::mask($msg);

        foreach ($this->clientSockets as $client) {
            socket_write($client, $msg, strlen($msg));
            printf("Send to %s\n", $client);
        }
        printf("\n");
    }

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
}
