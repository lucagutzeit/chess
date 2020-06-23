<?php
require_once __DIR__ . '/../../config/config.php';
require ROOT . 'src\WebSocket\ClientGroup.php';
require ROOT . 'src\game\GameMessage.php';

class GameGroup extends ClientGroup
{

    private $dbConnection;
    private $socketWhite;
    private $socketBlack;


    public function __construct(string $id, $dbConnection)
    {
        parent::__construct($id);

        $this->dbConnection = $dbConnection;
    }

    public function addClient($socket)
    {
        if ($this->clientCount() < 2) {
            parent::addClient($socket);
        } else {
            printf("Error: Game already full.");
        }
    }

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
                    }
                }
            }
        }
    }

    public function readyCheck()
    {
        if ($this->clientCount() === 2) {
            return true;
        } else {
            return false;
        }
    }

    public function decideColors()
    {
        if (rand() % 2) {
            $this->socketWhite = $this->getClientSockets()[1];
            $this->socketBlack = $this->getClientSockets()[0];
        } else {
            $this->socketWhite = $this->getClientSockets()[0];
            $this->socketBlack = $this->getClientSockets()[1];
        }
    }

    public function sendStartMessage()
    {
        // Prepare message for white player.
        $msg = new GameMessage("gameStart");
        $msg->setPlayerColor(0);
        $msg->mask();

        $maskedMsg = $msg->getMaskedMessage();
        socket_write($this->socketWhite, $maskedMsg, strlen($maskedMsg));

        // Prepare message for black player.
        $msg = new GameMessage("gameStart");
        $msg->setPlayerColor(1);
        $msg->mask();

        $maskedMsg = $msg->getMaskedMessage();
        socket_write($this->socketBlack, $maskedMsg, strlen($maskedMsg));

        printf("Send start message to game %s.", $this->getId());
    }

    public function sendErrorMessage(string $reason)
    {
        # code...
    }
}
