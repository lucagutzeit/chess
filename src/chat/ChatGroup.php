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
                $msg = $this->readMessage($socket);
                if ($msg != false) {
                    $msg->unmask();
                    switch ($msg->getOpcode()) {
                        case '8':
                            $this->removeClient($socket);
                            break;
                        default:
                            $data = json_decode($msg->getUnmaskedMessage());
                            $msg = $this->createUserMessage($data->name, $data->message, $this->color);
                            $this->sendToAll($msg);
                            break;
                    }
                }
            }
        }
    }

    /**
     * Creates a chat message send by an user.
     * @return ChatMessage returns a populated caht message
     */
    public function createUserMessage(string $userName, string $message, string  $color)
    {
        $msg = new ChatMessage('usermsg');
        $msg->setUsername($userName);
        $msg->setColor($color);
        $msg->setChatMessage($message);

        return $msg;
    }
}
