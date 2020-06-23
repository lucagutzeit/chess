<?php
require ROOT . 'src/WebSocket/Message.php';
class GameMessage extends Message
{
    private $type;

    private $playerColor;

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
