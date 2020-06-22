<?php
require __DIR__ . '/../WebSocket/Message.php';

class ChatMessage extends Message
{
    private $type;
    private $username;
    private $chatMessage;
    private $color;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
     * Getter for username.
     * @return string username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Setter for username.
     * @param string username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * Getter for chatMessage.
     * @return string chatMessage
     */
    public function getChatMessage()
    {
        return $this->chatMessage;
    }

    /**
     * Setter for chatMessage.
     * @param string chatMessage
     */
    public function setChatMessage(string $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    /**
     * Getter for color.
     * @return string color Returns a color as Hex color code.
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Setter for color.
     * @param string color Takes hex color code.
     */
    public function setColor(string $color)
    {
        $this->color = $color;
    }

    /**
     * Unmasks the message, saving the values of the header
     * using the parent function and decodes the unmaskes
     * message saving username and chat message.
     */
    public function unmask()
    {
        // Parent function for the header values.
        parent::unmask();

        $jsonData = json_decode($this->getUnmaskedMessage());

        if (!$jsonData == null) {
            $this->setChatMessage($jsonData->message);
            $this->setUsername($jsonData->name);
        }
    }

    /**
     * 
     */
    public function mask()
    {
        $arr['type'] = $this->getType();
        $arr['message'] = $this->getChatMessage();
        $arr['name'] = $this->getUsername();
        $arr['color'] = $this->getColor();

        $unmaskedMessage = json_encode($arr);

        $this->setLength(strlen($unmaskedMessage));
        $this->setUnmaskedMessage($unmaskedMessage);

        parent::mask();
    }
}
