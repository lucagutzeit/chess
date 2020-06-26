<?php
require_once __DIR__ . '/../../config/config.php';
require_once ROOT . 'src\WebSocket\ClientGroup.php';
require ROOT . 'src\game\GameMessage.php';

class Game extends ClientGroup
{
    private $dbConnection;
    private $playerWhite;
    private $playerBlack;
    private $state;

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
        $this->state = 0;
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
        if ($this->playerBlack != null) {
            if ($this->playerBlack->getName() === $user->getName()) {
                $this->playerBlack->setSocket($user->getSocket());
                return;
            }
        } elseif ($this->playerWhite != null) {
            if ($this->playerWhite->getName() === $user->getName()) {
                $this->playerWhite->setSocket($user->getSocket());
                return;
            }
        }

        if ($this->playerWhite == null) {
            $this->playerWhite = $user;

            $name = $user->getName();
            $id = $user->getGameId();

            $sql = $this->dbConnection->prepare('UPDATE games SET starter = ? WHERE id = ?');
            $sql->bind_param('si', $name, $id);
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
     * Gets all sockets from the connected users.
     * @return array Returns an array with all connected sockets of this game
     */
    public function getAllConnectedSockets()
    {
        $allSockets = array();
        $this->playerBlack != null ? $allSockets[] = $this->playerBlack->getSocket() : null;
        $this->playerWhite != null ? $allSockets[] = $this->playerWhite->getSocket() : null;
        return $allSockets;
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
                            $this->removeUser($socket);
                            /**
                             *  !! Victory goes to the one that did not disconnect. Remove after adding reconnect capabilities.
                             */
                            $this->playerBlack === null ? $this->sendGameOverMessage("white") : $this->sendGameOverMessage("black");
                            break;
                        case '1':
                            $this->evaluateMessage($this->getAllConnectedSockets(), $socket, $msg);
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

                $sql_gameOver_select = $this->dbConnection->prepare('SELECT player1, player2 FROM games WHERE id=?');
                $id = $this->getId();
                $sql_gameOver_select->bind_param('i', $id);
                $sql_gameOver_select->execute();
                $result = $sql_gameOver_select->get_result();
                $result = $result->fetch_assoc();
                $sql_gameOver_select->close();

                $jsonData->winner === "white" ? $name = $this->playerWhite->getName() : $name = $this->playerBlack->getName();
                $result['player1'] === $name ? $state = 2 : $state = 3;
                $sql_gameOver_update = $this->dbConnection->prepare('UPDATE games SET state = ? WHERE id=?');
                $id = $this->getId();
                $sql_gameOver_update->bind_param('ii', $state, $id);
                $sql_gameOver_update->execute();
                $sql_gameOver_update->close();

                // Add a win to the stats of the winner.
                $sql_winner_select = $this->dbConnection->prepare('SELECT win FROM nutzer WHERE Nickname=?');
                $name = ($state === 2 ? $result['player1'] : $result['player2']);
                $sql_winner_select->bind_param('s', $name);
                $sql_winner_select->execute;
                $result = $sql_winner_select->get_result();
                $result = $result->fetch_assoc();
                $win = $result['win'] + 1;
                $sql_winner_select->close();
                $sql_winner_update = $this->dbConnection->prepare('UPDATE nutzer SET win=? WHERE Nickname=?');
                $sql_winner_update->bind_param('is', $win, $name);
                $sql_winner_update->execute();
                $sql_winner_update->close();

                // Add a lose to the stats of the winner.
                $sql_loser_select = $this->dbConnection->prepare('SELECT lose FROM nutzer WHERE Nickname=?');
                $name = ($state === 2 ? $result['player2'] : $result['player1']);
                $sql_loser_select->bind_param('s', $name);
                $sql_loser_select->execute;
                $result = $sql_winner_select->get_result();
                $result = $result->fetch_assoc();
                $lose = $result['lose'] + 1;
                $sql_loser_select->close();
                $sql_loser_update = $this->dbConnection->prepare('UPDATE nutzer SET win=? WHERE Nickname=?');
                $sql_loser_update->bind_param('is', $lose, $name);
                $sql_loser_update->execute();
                $sql_loser_update->closer();
        }
    }

    /**
     * Checks if this game is full.
     * @return bool Returns true if game is full, false should that not be the case.
     */
    public function readyCheck()
    {
        if ($this->state === 0) {
            if ($this->playerBlack != null && $this->playerWhite != null) {
                $this->state = 1;
                return true;
            } else {
                return false;
            }
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
        $socketWhite = $this->playerWhite->getSocket();
        socket_write($socketWhite, $maskedMsg, strlen($maskedMsg));

        // Prepare message for black player.
        $msg = new GameMessage("gameStart");
        $msg->setPlayerColor(1);
        $msg->mask();

        $maskedMsg = $msg->getMaskedMessage();
        $socketBlack = $this->playerBlack->getSocket();
        socket_write($socketBlack, $maskedMsg, strlen($maskedMsg));

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
    public function sendGameOverMessage(string $winner)
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

    /**
     * Removes and closes connected socket. Checks the connected players for that socket.
     * @return bool Returns true if the socket is found and removed. False if not.
     */
    public function removeUser($socket)
    {
        if ($this->playerBlack != null) {
            if ($this->playerBlack->getSocket() === $socket) {
                $this->playerBlack = null;
                socket_close($socket);
                return true;
            }
        }

        if ($this->playerWhite != null) {
            if ($this->playerWhite->getSocket() === $socket) {
                $this->playerWhite = null;
                socket_close($socket);
                return true;
            }
        }

        return false;
    }

    public function sendToAll(Message $msg)
    {
        $msg->mask();
        $maskedMessage = $msg->getMaskedMessage();
        foreach ($this->getAllConnectedSockets() as $client) {
            if (!socket_write($client, $maskedMessage, strlen($maskedMessage))) {
                printf("Error:\n%s", socket_strerror(socket_last_error()));
            }
        }
    }
}
