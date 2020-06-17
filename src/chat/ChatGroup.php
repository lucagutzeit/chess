<?php
require __DIR__ . '/../Websocket/ClientGroup.php';

// TODO: Get colors from database.

class ChatGroup extends ClientGroup
{
    private $color;

    public function __construct()
    {
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
                    $jsonMsg = json_decode($msg, true);
                    $this->sendToAll($this->createUserMessage($jsonMsg['name'], $jsonMsg['message'], $jsonMsg['color']));
                }
            }
        }
    }

    /**
     * 
     */
    public function receiveMessage($socket)
    {
        $receivedMsg = false;
        if (socket_recv($socket, $buf, 1024, 0) >= 1) {
            $receivedMsg = MessageHandler::unmask($buf);
        }
        return $receivedMsg;
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
            'color' => $this->color
        ));

        return $jsonResponse;
    }
}
