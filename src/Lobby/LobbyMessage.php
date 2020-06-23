<?php
require __DIR__ . '/../WebSocket/Message.php';

class LobbyMessage extends Message
{
    private $type;
    private $gamesAdded;
    private $gamesRemoved;

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
     * Getter for gamesAdded
     * @return array gamesAdded
     */
    public function getGamesAdded()
    {
        return $this->gamesAdded;
    }

    /**
     * Setter for gamesAdded.
     * @param array gamesAdded
     */
    public function setGamesAdded(array $gamesAdded)
    {
        $this->gamesAdded = $gamesAdded;
    }

    /**
     * Getter for gamesRemoved.
     * @return array gamesRemoved
     */
    public function getGamesRemoved()
    {
        return $this->gamesRemoved;
    }

    /**
     * Setter for gamesRemoved.
     * @param array gamesRemoved
     */
    public function setGamesRemoved(array $gamesRemoved)
    {
        $this->gamesRemoved = $gamesRemoved;
    }

    /**
     * 
     */
    public function mask()
    {
        $arr['type'] = $this->getType();
        $arr['add'] = $this->getGamesAdded();
        $arr['remove'] = $this->getGamesRemoved();
        $unmaskedMessage = json_encode($arr);

        $this->setLength(strlen($unmaskedMessage));
        $this->setUnmaskedMessage($unmaskedMessage);

        parent::mask();
    }
}
