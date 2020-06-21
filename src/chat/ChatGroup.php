<?php

use function PHPSTORM_META\type;

require __DIR__ . '/../Websocket/ClientGroup.php';
require __DIR__ . '/ChatMessage.php';

// TODO: Get colors from database.
class ChatGroup extends ClientGroup
{
    // Color of usernames.
    private $color;

    /**
     * Construtctor
     * @param string $id Identification string of group
     */
    public function __construct(string $id)
    {
        parent::__construct($id);
        $this->color = '#007AFF';
    }

    /**
     * 
     */
    public function update()
    {
        $changed = $this->getReadableSockets();
        if (!empty($changed)) {

            foreach ($changed as $socket) {
                $msg = $this->receiveMessage($socket);
                if ($msg != false) {
                    $msg->unmask();
                    switch ($msg->getOpcode()) {
                        case '8':
                            $this->removeClient($socket);
                            socket_close($socket);
                            break;
                        default:
                            $msg->setType('usermsg');
                            $msg->setColor($this->color);
                            $msg->update();
                            $this->sendToAll($msg);
                            break;
                    }
                }
            }
        }
    }

    /**
     * @param WebSocket
     * @return ChatMessage|false returns a new Message object or false if there is no new message on the socket.
     */
    public function receiveMessage($socket)
    {
        if (socket_recv($socket, $buf, 1024, 0) > 0) {
            $receivedMsg = new ChatMessage();
            $receivedMsg->setMaskedMessage($buf);
            return $receivedMsg;
        }
        return false;
    }

    /**
     * 
     */
    public function createUserMessage($name, $message, $color)
    {
        $jsonResponse = json_encode(array(
            'type' => 'usermsg',
            'name' => $name,
            'message' => $message,
            'color' => $color
        ));

        return $jsonResponse;
    }
}
