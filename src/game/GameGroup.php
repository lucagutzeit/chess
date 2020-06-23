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
                            $this->evaluateMessage($changed, $socket, $msg);
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

        $receivingSockets = array_diff_key($sockets, [$senderSocket]);

        // If key black socket white. Und andersrum.
        switch ($jsonData->type) {
            case 'move':
                $xBefore = $jsonData->xBefore;
                $yBefore = $jsonData->yBefore;
                $xAfter = $jsonData->xAfter;
                $yAfter = $jsonData->yAfter;
                $this->sendMoveMessage($receivingSockets, $xBefore, $yBefore, $xAfter, $yAfter);
                break;
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
    public function sendMoveMessage(array $receivingSockets, $xBefore, $yBefore, $xAfter, $yAfter)
    {
        $msg = new GameMessage('chesspieceMove');
        $msg->setMoveAfter($xAfter, $yAfter);
        $msg->setMoveBefore($xBefore, $yBefore);

        $msg->mask();
        $maskedMsg = $msg->getMaskedMessage();
        foreach ($receivingSockets as $socket) {
            socket_write($socket, $maskedMsg, strlen($maskedMsg));
        }
    }

    /**
     * 
     */
    public function sendErrorMessage(string $reason)
    {
        # code...
    }

    /**
     * Get the sockets on which a message can be read. 
     * @return array Returns an array with sockets that can be read. 
     */
    public function getReadableSockets()
    {
        $changed = ["white" => $this->socketWhite, "black" => $this->socketBlack];
        if (!empty($changed)) {
            socket_select($changed, $null, $null, 0);
            return  $changed;
        } else {
            return array();
        }
    }
}
