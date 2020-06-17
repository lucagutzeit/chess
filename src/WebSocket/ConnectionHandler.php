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
     * @param Handshaker $handshaker Handshaker that performs the handshake
     * @return clientSocket|false returns the accepted socket. False if error.
     */
    public function receiveNewConnection(Handshaker $handshaker)
    {
        $changed[] = $this->connectionSocket;
        socket_select($changed, $null, $null, 0);
        if (!empty($changed)) {
            $newSocket = socket_accept($this->connectionSocket);
            $requestArray = $handshaker->readRequest($newSocket);

            // !! Debugging
            $this->printRequest($requestArray);

            if (!empty($requestArray)) {
                $response = $handshaker->createResponse($requestArray);
                socket_write($newSocket, $response, strlen($response));

                // Catching error codes
                if ($response === -2) {
                    printf("Handshake not successful. Upgrade request denied.\nOrigin is not allowed.\n");
                } elseif ($response === -1) {
                    printf("Handshake not successful. Upgrade request denied.\nProtocol not supported.\n");
                } elseif ($response === 0) {
                    printf("Handshake not successful. Upgrade request denied.\nNo protocol set.\n");
                } else {
                    printf("Handshake successful\n");
                    return $newSocket;
                }
            } else {
                print("Error: Request is empty.\n");
                return false;
            }
        }
    }

    /**
     * !! Help function
     * !! Delete after use
     */
    public function printRequest(array $request)
    {
        print("_________________\nStart of request:\n");
        foreach ($request as $key => $value) {
            printf("%s : %s\n", $key, $value);
        }
        print("End of request\n______________\n\n");
    }
}
