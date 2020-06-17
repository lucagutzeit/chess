<?php
class ClientSocker
{
    //
    private $socket;

    /**
     * 
     */
    public function __construct($socket)
    {
        $this->socket = $socket;
    }


    /**
     * 
     */
    public function getSocket()
    {
        return $this->socket;
    }
}
