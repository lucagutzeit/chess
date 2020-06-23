<?php
require_once __DIR__ . '\..\src\WebSocket\ConnectionHandler.php';
require_once __DIR__ . '\..\src\Websocket\Handshaker.php';
require __DIR__ . '\..\src\Chat\ChatGroup.php';

$null = NULL;
$host = '127.0.0.1';
$portGame = '9090';
$protocols = ['games'];

print("Chat daemon started\n\n");

$chatConnections = new ConnectionHandler($host, $portGame);
$handshaker = new Handshaker($protocols, [$host]);
$allChat = new ChatGroup("chatGlobal");

while (true) {
    // Chech for new connection request
    $newSocket = $chatConnections->receiveNewConnection($handshaker);
    if ($newSocket != false) {

        // Read request and create response
        $requestArray = $handshaker->readRequest($newSocket);
        $response = $handshaker->createResponse($requestArray);

        printRequest($requestArray);

        // Send response to the socket from which the request originates
        socket_write($newSocket, $response, strlen($response));

        // add the new socket to the chat
        $allChat->addClient($newSocket);
    }
}
/**
 * !! Help function
 */
function printRequest(array $requestArray)
{
    print("_________________\nStart of request:\n");
    foreach ($requestArray as $key => $value) {
        printf("%s : %s\n", $key, $value);
    }
    print("End of request\n______________\n\n");
}
