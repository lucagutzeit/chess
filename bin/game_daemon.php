<?php
require_once __DIR__ . '\..\src\WebSocket\ConnectionHandler.php';
require_once __DIR__ . '\..\src\Websocket\Handshaker.php';
require __DIR__ . '\..\src\Chat\ChatGroup.php';

$null = NULL;
$host = '127.0.0.1';
$portChat = '9001';
$protocols = ['games'];

print("Chat daemon started\n\n");

$chatConnections = new ConnectionHandler($host, $portChat);
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

    $allChat->update();
}
