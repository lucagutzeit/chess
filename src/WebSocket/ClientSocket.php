<?php
class ClientSocket
{
    // WebSocket
    private $socket;

    /**
     * Constructor
     * @param WebSocket $socket
     */
    public function __construct($socket)
    {
        $this->socket = $socket;
    }

    /**
     * Getter for the saved socket
     * @return WebSocket returns $socket
     */
    public function getSocket()
    {
        return $this->socket;
    }
}
