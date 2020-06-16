<?php
require __DIR__ . '/../Websocket/ClientGroup.php';
class ChatGroup extends ClientGroup
{
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
    public function receiveMessage($socket)
    {
        if (socket_recv($socket, $buf, 1024, 0) >= 1) {
            $receivedMsg = MessageHandler::unmask($buf);
            return $receivedMsg;
        }
        return false;
    }

    public function createUserMessage($name, $message, $color)
    {
        $jsonResponse = json_encode(array('type' => 'usermsg', 'name' => $name, 'message' => $message, 'color' => $color));

        return $jsonResponse;
    }
}
