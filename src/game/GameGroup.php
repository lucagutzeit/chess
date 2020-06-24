<?php
require_once __DIR__ . '/../../config/config.php';
require ROOT . 'src\WebSocket\ClientGroup.php';
require ROOT . 'src\game\GameMessage.php';

class GameGroup extends ClientGroup
{
    private $dbConnection;
    private $socketWhite;
    private $socketBlack;

    private $playerOnTurn;
    private $boardstate;

    /**
     * Constructor
     * @param string id Identifier of this game.
     * @param sql_smnt Connection to a database.
     */
    public function __construct(string $id, $dbConnection)
    {
        parent::__construct($id);

        $this->dbConnection = $dbConnection;
        $this->playerOnTurn = 0;
    }

    /**
     * Adds a new client to the game. Cannot have more then 2 connected clients.
     * @return bool Returns false if tehre are already 2 connected clients. True if the client has been added.
     */
    public function addClient($socket)
    {
        if ($this->clientCount() < 2) {
            parent::addClient($socket);
            return true;
        } else {
            printf("Error: Game already full.");
            return false;
        }
    }

    /**
     * Checks for new incoming messages and handels them.
     */
    public function update()
    {
        $changed = $this->getReadableSockets();
        if (!empty($changed)) {

            foreach ($changed as $key => $socket) {
                $msg = $this->readMessage($socket);
                if ($msg != false) {
                    $msg->unmask();
                    switch ($msg->getOpcode()) {
                        case '8':
                            $this->removeClient($socket);
                            break;
                        case '1':
                            $this->evaluateMessage($this->getClientSockets(), $socket, $msg);
                            break;
                    }
                }
            }
        }
    }

    /**
     * 
     * @param 
     */
    public function evaluateMessage(array $sockets, $senderSocket, Message $msg)
    {
        $jsonData = json_decode($msg->getUnmaskedMessage());

        // If key black socket white. Und andersrum.
        switch ($jsonData->type) {
            case 'chesspieceMove':
                $receivingSockets = array_diff($sockets, [$senderSocket]);
                $xBefore = $jsonData->xBefore;
                $yBefore = $jsonData->yBefore;
                $xAfter = $jsonData->xAfter;
                $yAfter = $jsonData->yAfter;
                $enemyInCheck = $jsonData->enemyInCheck;
                $this->sendMoveMessage($receivingSockets, $xBefore, $yBefore, $xAfter, $yAfter, $enemyInCheck);
                break;
            case 'gameOver':
                $this->sendGameOverMessage($jsonData->winner);
        }
    }

    /**
     * Checks if this game is full.
     * @return bool Returns true if game is full, false should that not be the case.
     */
    public function readyCheck()
    {
        if ($this->clientCount() === 2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Allocates the colors randomly between the players.
     */
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

    /**
     * Sends a start Message to all Players. Transmits which player may make the first move.
     */
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

    /**
     * Sends a message with a move to the given client.
     * @param WebSocket $socket Socket which should receive the move.
     */
    public function sendMoveMessage(array $receivingSockets, $xBefore, $yBefore, $xAfter, $yAfter, $enemyInCheck)
    {
        $msg = new GameMessage('chesspieceMove');
        $msg->setMoveAfter($xAfter, $yAfter);
        $msg->setMoveBefore($xBefore, $yBefore);
        $msg->setInCheck($enemyInCheck);

        $msg->mask();
        $maskedMsg = $msg->getMaskedMessage();
        foreach ($receivingSockets as $socket) {
            socket_write($socket, $maskedMsg, strlen($maskedMsg));
        }
    }

    /**
     * Sends a message containing
     * @param string "black"|"white" color of the winner. 
     */
    public function sendGameOverMessage($winner)
    {
        $msg = new GameMessage('gameOver');
        $msg->setWinner($winner);

        $this->sendToAll($msg);
    }

    /**
     * 
     */
    public function sendErrorMessage(string $reason)
    {
        # code...
    }
}
