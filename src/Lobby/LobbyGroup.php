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
        $this->openGames = array();
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
        $newOpenGames = array();

        $query = $this->dbConnection->prepare("SELECT * FROM games WHERE state=0"); //? Check for player1 or player2 = null.
        $query->execute();
        $sql_results = $query->get_result();

        while ($result = $sql_results->fetch_assoc()) {
            $newOpenGames[$result['id']] = ["name" => $result['name'], 'player1' => $result['player1'], 'player2' => $result['player2'], 'state' => 0];
        }

        if (!empty($newOpenGames)) {
            $updateMessage = new LobbyMessage();
            $updateMessage->setGames($newOpenGames);
            $updateMessage->setType('update');
            $this->sendToAll($updateMessage);
        }
    }
}
