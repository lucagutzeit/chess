<?php
require __DIR__ . '/../DBConnection.php';
require __DIR__ . '/../WebSocket/ClientGroup.php';
require __DIR__ . '/LobbyMessage.php';
require __DIR__ . '/../Game/Game.php';


class LobbyGroup extends ClientGroup
{
    private $openGames;

    private $dbConnection;

    public function __construct(string $name, object $dbConnection)
    {
        parent::__construct($name);
        $this->dbConnection = $dbConnection;

        $query = $this->dbConnection->prepare("SELECT id, name, player1, player2  FROM games WHERE state=0");
        $query->execute();
        $sql_results = $query->get_result();

        while ($result = $sql_results->fetch_assoc()) {
            $this->openGames[$result['id']] = ["name" => $result['name'], 'player1' => $result['player1'], 'player2' => $result['player2']];
        }
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
     * 
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
        /* 
        $removedGames = $this->openGames;
        $newOpenGames = array();

        $query = $this->dbConnection->prepare("SELECT id, name, player1, player2  FROM games WHERE state=0"); //? Check for player1 or player2 = null.
        $query->execute();
        $sql_results = $query->get_result();

        while ($result = $sql_results->fetch_assoc()) {
            $newOpenGames[$result['id']] = ["name" => $result['name'], 'player1' => $result['player1'], 'player2' => $result['player2']];
            unset($removedGames[$result['id']]);
        }

        if (!empty($newOpenGames)) {
            $updateMessage = new LobbyMessage();
            $updateMessage->setGames($newOpenGames);
            $updateMessage->setType('update');
            $this->sendToAll($updateMessage);
        }

        if (!empty($removedGames)) {
            $removedMessage = new LobbyMessage();
            $removedMessage->setType('remove');
            $removedMessage->setGames($removedGames);
            $this->sendToAll($removedMessage);
        } */
    }

    public function sendInitial($socket)
    {
        $allGamesMessage = new LobbyMessage();
        $allGamesMessage->setType('add');
        $allGamesMessage->setGames($this->openGames);
        $allGamesMessage->mask();

        $maskedMessage = $allGamesMessage->getMaskedMessage();
        if (!socket_write($socket, $maskedMessage, strlen($maskedMessage))) {
            printf("Error:\n%s", socket_strerror(socket_last_error()));
        }
    }

    public function updateGames()
    {
        $this->openGames;
    }
}
