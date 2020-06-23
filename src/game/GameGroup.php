<?php
require __DIR__ . '/../../config/config.php';
require ROOT . 'src\WebSocket\ClientGroup.php';
require ROOT . 'src\game\GameMessage';

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
        if ($this->getClientCount() < 2) {
            parent::addClient($socket);
        } else {
            printf("Error: Game already full.");
        }
    }

    public function readyCheck()
    {
        if ($this->getClientCount() === 2) {
            return true;
        } else {
            return false;
        }
    }

    public function decideColors()
    {
        if (rand() % 2) {
            $this->socketWhite = $this->clientSockets[1];
            $this->socketBlack = $this->clientSockets[0];
        } else {
            $this->socketWhite = $this->clientSockets[0];
            $this->socketBlack = $this->clientSockets[1];
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
    }

    public function sendErrorMessage(string $reason)
    {
        # code...
    }
}
