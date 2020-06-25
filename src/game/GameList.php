<?php
class GameList
{
    // Array of all open games.
    private $games;

    public function __construct()
    {
        $this->games = array();
    }


    public function addClientToGame($socket, $gameID)
    {
        if (empty($this->games[$gameID])) {
            $this->games[$gameID] = new GameGroup($gameID);
        }

        $this->games[$gameID]->addClient($socket);
    }
}
