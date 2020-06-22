<?php
require __DIR__ . '/../WebSocket/Message.php';

class LobbyMessage extends Message
{
    private $type;
    private $games;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    /** 
     * Getter for type.
     * @return string type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Setter for type.
     * @param string type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * Getter for games
     * @return array games
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Setter for games.
     * @param array games
     */
    public function setGames(array $games)
    {
        $this->games = $games;
    }

    /**
     * 
     */
    public function mask()
    {
        $arr['type'] = $this->getType();
        $arr['games'] = $this->getGames();

        $unmaskedMessage = json_encode($arr);

        $this->setLength(strlen($unmaskedMessage));
        $this->setUnmaskedMessage($unmaskedMessage);

        parent::mask();
    }
}
