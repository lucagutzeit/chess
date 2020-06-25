<?php
require_once __DIR__ . '/../../config/config.php';
require ROOT . 'src/game/User.php';
require_once ROOT . 'src/WebSocket/ClientGroup.php';
require ROOT . 'src/game/Game.php';
class GameList extends ClientGroup
{
    // Array of all open games.
    private $runningGames;
    // Arrat of users that need to be identified.
    private $waitingUser;
    // Connection to database
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->runningGames = array();
        $this->waitingUser = array();
        $this->dbConnection = $dbConnection;
    }

    /**
     * Adds a new user to the list of waitingUsers.
     * @param User User to add
     */
    public function addWaitingUser(User $user)
    {
        $this->waitingUser[] = $user;
    }

    /**
     * Checks if a user send a identification message and moves the user in the corresponding game.
     */
    public function updateWaitingUsers()
    {
        foreach ($this->waitingUser as $user) {
            $socket[] = $user->getSocket();
            socket_select($socket, $null, $null, 0);

            if (!empty($socket)) {
                $msg = $this->readMessage(array_pop($socket));
                if ($msg != false) {
                    $msg->unmask();
                    if ($msg->getOpcode() == '8') {
                        socket_close(array_pop($socket));
                        $this->unwaitUser($user);
                    } else {
                        $jsonData = json_decode($msg->getUnmaskedMessage());
                        if ($jsonData->type === 'id') {
                            $name = $jsonData->name;
                            $name = ltrim($name);
                            $name = rtrim($name);
                            $user->setName($name);
                            $user->setGameId($jsonData->gameId);

                            if ($this->addUserToGame($user, $jsonData->gameId)) {
                                $this->unwaitUser($user);
                            } else {
                                $this->sendError($socket, "Wrong game id.");
                            }
                        } else {
                            $this->sendError($socket, "Wrong message format");
                            socket_close($socket);
                            $this->unwaitUser($user);
                        }
                    }
                }
            }
        }
    }

    /**
     * Calls the update function on all open games.
     */
    public function updateAllGames()
    {
        foreach ($this->runningGames as $game) {
            $game->update();
            if ($game->readyCheck()) {
                $game->sendStartMessage();
            }
        }
    }

    /**
     * Adds a user to the game that with the matching id.
     * @param User User to add
     * @param int Id of the game the user is added to.
     */
    public function addUserToGame(User $user, int $gameId)
    {
        $username = $user->getName();
        $userCheck = $this->dbConnection->prepare('SELECT * FROM games WHERE id=? AND (player1=? OR player2 = ?)');
        $userCheck->bind_param('iss', $gameId, $username, $username);
        $userCheck->execute();
        $result = $userCheck->get_result();
        if ($result->num_rows != 1) {
            $this->sendError($user->getSocket(), "Wrong game id.");
            return false;
        } else {
            if (isset($this->runningGames[$gameId])) {
                $this->runningGames[$gameId]->addUser($user);
            } else {
                $newGame = new Game($gameId, $this->dbConnection);
                $newGame->addUser($user);
                $this->runningGames[$gameId] = $newGame;
            }
            return true;
        }
    }

    /**
     * Removes a user from the list of waiting users.
     * @param User User to remove;
     * @return bool Returns true after removing teh user. False if the user could
     * not be found.
     */
    public function unwaitUser(User $user)
    {
        $toRemove = array_search($user, $this->waitingUser);
        if ($toRemove !== false) {
            unset($this->waitingUser[$toRemove]);
            return true;
        } else {
            return false;
        }
    }

    public function sendValidationRequestToAll()
    {
        $msg = new Message();
        $arr['type'] = "validate";
        $msg->setUnmaskedMessage(json_encode($arr));
        $msg->mask();
        $maskedMessage = $msg->getMaskedMessage();
        foreach ($this->waitingUser as $user) {
            $socket = $user->getSocket();
            if (!socket_write($socket, $maskedMessage, strlen($maskedMessage))) {
                printf("Error:\n%s", socket_strerror(socket_last_error()));
            } else {
                printf("Send to %s\n", $socket);
            }
        }
    }
}
