<?php
require_once __DIR__ . '\..\src\WebSocket\ConnectionHandler.php';
require_once __DIR__ . '\..\src\Websocket\Handshaker.php';
require __DIR__ . '\..\src\Chat\ChatGroup.php';

$null = NULL;
$host = '127.0.0.1';
$portChat = '9001';
$protocols = ['chat'];

print("Chat daemon started\n\n");

$chatConnections = new ConnectionHandler($host, $portChat);
$handshaker = new Handshaker($protocols, [$host]);
$allChat = new ChatGroup("chatGlobal");

while (true) {
    $newSocket = $chatConnections->receiveNewConnection($handshaker);
    if ($newSocket != false) {
        $allChat->addClient($newSocket);
    }

    $allChat->update();
}
