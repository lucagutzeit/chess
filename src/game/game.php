<?php
class Game
{
    private $playerWhite;
    private $playerBlack;
    private $state;
    private $name;
    private $id;

    public function __construct($id, $name, $state, $playerBlack, $playerWhite)
    {
        $this->id = $id;
        $this->name = $name;
        $this->state = $state;
        $this->playerBlack = $playerBlack;
    }
}
