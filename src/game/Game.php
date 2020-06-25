<?php
require_once __DIR__ . '/../../config/config.php';
require ROOT . 'src\WebSocket\ClientGroup.php';
require ROOT . 'src\game\GameMessage.php';

class Game extends ClientGroup
{
    private $dbConnection;
    private $playerWhite;
    private $playerBlack;

    /**
     * Constructor
     * @param int id Identifier of this game.
     * @param sql_smnt dbConnection Connection to a database.
     */
    public function __construct(int $id, $dbConnection)
    {
        parent::__construct($id);
        $this->dbConnection = $dbConnection;
        $this->playerWhite = null;
        $this->playerBlack = null;
    }

    /**
     * Adds a new User to the game. Cannot have more then 2 user. 
     * Sould a third user try to connected, a error message is send as response.
     * @param User The user
     * @return bool Returns false if tehre are already 2 connected user. 
     * True if the user has been added.
     */
    public function addUser(User $user)
    {
        if ($this->playerWhite == null) {
            $this->playerWhite = $user;

            $sql = $this->dbConnection->prepare('UPDATE games SET starter = ? WHERE id = ?');
            $sql->bind_param('si', $user->getName(), $this->getId());
            $sql->execute();
            $sql->close();
            return true;
        } elseif ($this->playerBlack == null) {
            $this->playerBlack = $user;
            return true;
        } else {
            $this->sendError($user->getSocket(), "This game is already full.");
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

            foreach ($changed as $socket) {
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
        if ($this->playerBlack != null && $this->playerWhite != null) {
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
     * Check if the any socket from a player is readable and returns an array with
     * these readable sockets.
     * @return array Returns an array with all sockets that can be read.
     */
    public function getReadableSockets()
    {
        $changed = array();
        $this->playerBlack != null ? $changed[] = $this->playerBlack->getSocket() : null;
        $this->playerWhite != null ? $changed[] = $this->playerWhite->getSocket() : null;

        if (!empty($changed)) {
            socket_select($changed, $null, $null, 0);
            if (!empty($changed)) {
                socket_select($changed, $null, $null, 0);
                return  $changed;
            } else {
                return array();
            }
        }
    }
}
