<?php
require_once __DIR__ . '\..\src\WebSocket\ConnectionHandler.php';
require_once __DIR__ . '\..\src\Websocket\Handshaker.php';
require __DIR__ . '\..\src\Lobby\LobbyGroup.php';
require __DIR__ . '\..\src\DBconnection.php';

$null = NULL;
$host = '127.0.0.1';
$portChat = '9002';
$protocols = ['lobby'];

print("Lobby daemon started\n\n");

$lobbyConnections = new ConnectionHandler($host, $portChat);
$handshaker = new Handshaker($protocols, [$host]);
$lobby = new LobbyGroup('Lobby', $connection);

while (true) {
    $newSocket = $lobbyConnections->receiveNewConnection();

    if ($newSocket != false) {
        $requestArray = $handshaker->readRequest($newSocket);
        $response = $handshaker->createResponse($requestArray);

        printRequest($requestArray);

        socket_write($newSocket, $response, strlen($response));

        $lobby->addClient($newSocket);
    }

    $lobby->update();
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
