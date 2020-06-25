<?php
require_once __DIR__ . '/../config/config.php';
require ROOT . 'src/WebSocket/ConnectionHandler.php';
require ROOT . 'src/Websocket/Handshaker.php';
require ROOT . 'src/game/GameList.php';
require ROOT . 'src/DBConnection.php';

$null = NULL;
$host = '127.0.0.1';
$portGame = '9090';
$protocols = ['game'];

print("Game daemon started\n\n");

$chatConnections = new ConnectionHandler($host, $portGame);
$handshaker = new Handshaker($protocols, [$host]);
$games = new GameList($connection);

while (true) {
    // Check for new connection request
    $newSocket = $chatConnections->receiveNewConnection($handshaker);
    if ($newSocket != false) {

        // Read request and create response
        $requestArray = $handshaker->readRequest($newSocket);
        $response = $handshaker->createResponse($requestArray);

        printRequest($requestArray);

        // Send response to the socket from which the request originates
        socket_write($newSocket, $response, strlen($response));

        // add the new user to the waiting users.
        $games->addWaitingUser(new User($newSocket, $requestArray));
    }
    /*     $games->sendValidationRequestToAll(); */
    $games->updateWaitingUsers();
    $games->updateAllGames();
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
