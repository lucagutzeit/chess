<?php
require ROOT . 'src/WebSocket/Message.php';
class GameMessage extends Message
{

    private $type;

    private $playerColor;

    private $moveBefore;
    private $moveAfter;

    public function __construct(string $type)
    {
        parent::__construct();
        $this->type = $type;
    }

    /**
     * Getter for type.
     * @return string type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Setter for type.
     * @param string type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * Getter for playerColor.
     * @return string playerColor
     */
    public function getPlayerColor()
    {
        return $this->playerColor;
    }

    /**
     * Setter for playerColor.
     * @param boolean $playerColor 0 for white. 1 for black.
     */
    public function setPlayerColor(bool $playerColor)
    {
        $this->playerColor = $playerColor ? "black" : "white";
    }

    /**
     * Getter for moveBefore.
     * @return array moveBefore
     */
    public function getMoveBefore()
    {
        return $this->moveBefore;
    }

    /**
     * Setter for moveBefore.
     * @param int x
     * @param int y
     */
    public function setMoveBefore(int $x, int $y)
    {
        $this->moveBefore = [$x, $y];
    }

    /**
     * Getter for moveAfter.
     * @return array moveAfter
     */
    public function getMoveAfter()
    {
        return $this->moveAfter;
    }

    /**
     * Setter for moveAfter.
     * @param int x
     * @param int y
     */
    public function setMoveAfter(int $x, int $y)
    {
        $this->moveAfter = [$x, $y];
    }

    /**
     * 
     */
    public function mask()
    {
        $arr = array();
        switch ($this->type) {
            case 'gameStart':
                $arr['type'] = "gameStart";
                $arr['playerColor'] = $this->getPlayerColor();
                break;
            case 'move':
                $arr['type'] = "chesspieceMove";
                $moveBefore = $this->getMoveBefore();
                $arr['xBefore'] = $moveBefore[0];
                $arr['yBefore'] = $moveBefore[1];
                $moveAfter = $this->getMoveAfter();
                $arr['xAfter'] = $moveAfter[0];
                $arr['yAfter'] = $moveAfter[1];
                break;
            default:
                printf("%s is not an supportyed type for GameMessage", $this->type);
                return false;
        }

        $unmaskedMessage = json_encode($arr);

        $this->setLength(strlen($unmaskedMessage));
        $this->setUnmaskedMessage($unmaskedMessage);

        parent::mask();
    }
}
