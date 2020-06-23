<?php
require __DIR__ . '/../../config/config.php';
require ROOT . 'src\WebSocket\ClientGroup.php';

class GameGroup extends ClientGroup
{

    private $dbConnection;
    private $socketWhite;
    private $socketBlack;


    public function __construct(string $id, $dbConnection)
    {
        parent::__construct($id);

        $this->dbConnection = $dbConnection;
    }

    public function addClient($socket)
    {
        if () {
            # code...
        }
    }

    public function readyCheck()
    {
    }
}
