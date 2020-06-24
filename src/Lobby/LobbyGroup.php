<?php
require __DIR__ . '/../../config/config.php';
require ROOT . 'src/DBConnection.php';
require ROOT . 'src/WebSocket/ClientGroup.php';
require ROOT . 'src/Lobby/LobbyMessage.php';


class LobbyGroup extends ClientGroup
{
    private $openGames;

    private $dbConnection;

    /**
     * Constructor
     */
    public function __construct(string $name, object $dbConnection)
    {
        parent::__construct($name);
        $this->dbConnection = $dbConnection;

        $this->openGames = $this->getDataFromDb();
    }

    /**
     * Getter for openGames;
     * @return array openGames Returns an array of all open games.
     */
    public function getOpenGames()
    {
        return $this->openGames;
    }

    /**
     * Setter for openGames.
     * @param array openGames
     */
    public function setOpenGames(array $openGames)
    {
        $this->openGames = $openGames;
    }

    /**
     * Gets the games data from the Db provided in dbConnection.
     * @return array Returns an array with all open games.
     */
    public function getDataFromDb()
    {
        $query = $this->dbConnection->prepare("SELECT id, name, player1, player2  FROM games WHERE state=0");
        $query->execute();
        $sql_results = $query->get_result();

        $openGames = array();
        while ($result = $sql_results->fetch_assoc()) {
            $openGames[$result['id']] = ["id" => $result['id'], "name" => $result['name'], 'player1' => $result['player1'], 'player2' => $result['player2']];
        }

        return $openGames;
    }

    /**
     * Reads incoming messages and evaluates what is to be done with them.
     * 
     * Only checks for opcode 0x8 and closes the socket on such an message.
     * All other uncoming messages ar ignored.
     */
    public function update()
    {
        // Read Messages from clients
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

    /**
     * Sends all open games to socket.
     * @param WeoSocket $socket Socket in need of initial game list.
     * 
     * Normally this is used to send the games to a socket that is new connected.
     */
    public function sendInitial($socket)
    {
        $initialMessage = $this->createUpdateMessage($this->getOpenGames(), array());
        $initialMessage->mask();

        $maskedMessage = $initialMessage->getMaskedMessage();
        if (!socket_write($socket, $maskedMessage, strlen($maskedMessage))) {
            printf("Error:\n%s", socket_strerror(socket_last_error()));
        }
    }

    /**
     * Checks the database for changes. If there are any a messages with added and removed games is send to all clients.
     */
    public function updateGames()
    {
        $openGamesOld = $this->getOpenGames();
        $openGamesNew = $this->getDataFromDb();

        $gamesAdded = array_diff_key($openGamesNew, $openGamesOld);
        $gamesRemoved = array_diff_key($openGamesOld, $openGamesNew);

        if (!(empty($gamesAdded) && empty($gamesRemoved))) {
            $msg = $this->createUpdateMessage($gamesAdded, $gamesRemoved);
            $this->sendToAll($msg);
        }

        $this->openGames = $openGamesNew;
    }

    /**
     * Creates a LobbyMessage with type update.
     * @param array $gamesAdded Array that contains the added games.
     * @param array $gamesRemoved Array that contains the removed games.
     * @return LobbyMessage returns new LobbyMessage.
     */
    public function createUpdateMessage($gamesAdded, $gamesRemoved)
    {
        $updateMsg = new LobbyMessage();
        $updateMsg->setType('update');
        $updateMsg->setGamesAdded($gamesAdded);
        $updateMsg->setGamesRemoved($gamesRemoved);

        return $updateMsg;
    }
}
