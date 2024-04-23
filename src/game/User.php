<?php
class User
{
    private $name;
    private $gameId;
    private $socket;
    private $request;

    /**
     * Constructor
     */
    public function __construct($socket, array $request)
    {
        $this->socket = $socket;
        $this->request = $request;
    }

    /** 
     * Getter for name.
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter for name
     * @param string name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Getter for gameId.
     * @return int gameId
     */
    public function getGameId()
    {
        return $this->gameId;
    }

    /**
     * Setter for gameId.
     * @param int gameId.
     */
    public function setGameId(int $gameId)
    {
        $this->gameId = $gameId;
    }

    /**
     * Getter for socket.
     * @return WebSocket socket
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * Setter for socket.
     * @param WebSocket socket
     */
    public function setSocket($socket)
    {
        $this->socket = $socket;
    }

    /**
     * Getter for request
     * @return array request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Setter for request
     * @param array request
     */
    public function setRequest(array $request)
    {
        $this->request = $request;
    }
}
