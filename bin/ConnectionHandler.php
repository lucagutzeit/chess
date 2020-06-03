<?php
class ConnectionHandler
{
    private $connectionSocket; // WebSocket on the server which receives connection requests from clients
    private $clients;


    public function __construct($host, $port, $clients = array())
    {
        $this->connectionSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        socket_bind($this->connectionSocket, $host, $port);
        socket_listen($this->connectionSocket);
        socket_set_option($this->connectionSocket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_set_nonblock($this->connectionSocket);

        $this->clients = $clients;
    }

    public function getConnectionSocket()
    {
        return $this->connectionSocket;
    }

    public function getClients()
    {
        return $this->clients;
    }


    public function addClient($socket, $key = NULL)
    {
        if ($key === NULL) {
            $this->clients[] = $socket;
        } else {
            $this->clients[$key] = $socket;
        }

        print(implode('|', $this->clients));
    }

    public function removeClient($socket)
    {
        if ($key = array_search($socket, $this->clients) !== false) {
            unset($this->clients[$key]);
            return true;
        } else {
            print('Not in $clients');
            return false;
        }
    }

    public function getNewConnections()
    {
        $newConnections = array();
        while (($socket_new = socket_accept($this->connectionSocket)) != false) {
            $newConnections[] = $socket_new;
        }

        if (empty($newConnections)) {
            return false;
        } else {
            return $newConnections;
        }
    }
}
