<?php
$null = null;
class ConnectionHandler
{
    // WebSocket on the server which receives connection requests from clients
    private $connectionSocket;

    /**
     * Constructor
     * 
     * @param String $host 
     * @param String $port
     */
    public function __construct(String $host, String $port)
    {
        // Create and initialize new WebSocket.
        $this->connectionSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        // SetUp for WebSocket.
        socket_bind($this->connectionSocket, $host, $port);
        socket_listen($this->connectionSocket);
        socket_set_option($this->connectionSocket, SOL_SOCKET, SO_REUSEADDR, 1);
    }

    /**
     * Checks if there is a new Request on the socket, initiates a handshake and adds it
     * to $client with the subprotocol as its key.
     * 
     * @return socket|null returns the accepted socket. Returns false , if there is no new connection 
     */
    public function receiveNewConnection()
    {
        $changed[] = $this->connectionSocket;
        socket_select($changed, $null, $null, 0);

        if (!empty($changed)) {
            $newSocket = socket_accept($this->connectionSocket);
            return $newSocket;
        } else {
            return false;
        }
    }
}
