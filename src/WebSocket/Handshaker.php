<?php
class Handshaker
{
    // Array of all supported protocols.
    private $supportedProtocols;
    // Array of allowed origins.
    private $allowedOrigins;

    /**
     * Constructor
     * @param array $supportedProtocols 
     */
    public function __construct(array $supportedProtocols, array $allowedOrigins)
    {
        $this->supportedProtocols = $supportedProtocols;
        $this->allowedOrigins = $allowedOrigins;
    }

    /**
     * 
     */
    public function readRequest($socket)
    {
        $requestArray = array();

        // Getting the HTTP request from $socket
        $requestHeader = socket_read($socket, 1024);

        // Splitting the request into single lines
        $lines = preg_split("/\r\n/", $requestHeader);

        /**
         * Splitting each line into key and value.
         * Saving everything as key/value Pair in $requestData
         */
        foreach ($lines as $line) {
            if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
                $requestArray[$matches[1]] = $matches[2];
            } else if (preg_match('/(GET) (.*)/', $line, $matches)) {
                $requestArray[$matches[1]] = $matches[2];
            }
        }

        return $requestArray;
    }

    /**
     * 
     * 
     */
    public function createResponse(array $requestArray)
    {
        //base 64 encode after Hash with magic string.
        $secKeyAccept = base64_encode(pack('H*', sha1($requestArray['Sec-WebSocket-Key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));

        // Handshake response
        $acceptHeader = "HTTP/1.1 101 Switching Protocols\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "Sec-WebSocket-Accept:$secKeyAccept\r\n\r\n";;

        return $acceptHeader;
    }

    public function verifyProtocol()
    {
    }
}
