<?php
require_once 'ConnectionHandler.php';

$host = '127.0.0.1';
$port = '9000';
$null = NULL;

$safe = new ConnectionHandler($host, $port);

echo "Chat daemon started\nListening socket created\n\n";

while (true) {
    if (($newConnections = $safe->getNewConnections()) != false) {
        foreach ($newConnections as $socket) {

            $safe->addClient($socket);
        }
    }
}
