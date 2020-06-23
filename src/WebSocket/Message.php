<?php
class Message
{
    private $fin;
    private $rsv1;
    private $rsv2;
    private $rsv3;
    private $opcode;
    private $isMasked;
    private $length;
    private $maskedMessage;
    private $unmaskedMessage;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fin = 128;
        $this->rsv1 = 0;
        $this->rsv2 = 0;
        $this->rsv3 = 0;
        $this->opcode = 0x1;
        $this->isMasked = false;
    }

    /**
     * Getter for fin.
     * @return Integer fin
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Setter for fin.
     * @param int fin
     */
    public function setFin(int $fin)
    {
        $this->fin = $fin;
    }

    /**
     * Getter for rsv1.
     * @return int rsv1
     */
    public function getRsv1()
    {
        return $this->rsv1;
    }

    /**
     * Setter for rsv1.
     * @param int rsv1
     */
    public function setRsv1(int $rsv1)
    {
        $this->rsv1 = $rsv1;
    }

    /**
     * Getter for rsv2.
     * @return int rsv2
     */
    public function getRsv2()
    {
        return $this->rsv2;
    }

    /**
     * Setter for rsv2.
     * @param int rsv2
     */
    public function setRsv2(int $rsv2)
    {
        $this->rsv2 = $rsv2;
    }

    /**
     * Getter for rsv3.
     * @return int rsv3
     */
    public function getRsv3()
    {
        return $this->rsv3;
    }

    /**
     * Setter for rsv3.
     * @param int rsv3
     */
    public function setRsv3(int $rsv3)
    {
        $this->rsv3 = $rsv3;
    }

    /**
     * Getter for opcode.
     * @return int opcode
     */
    public function getOpcode()
    {
        return $this->opcode;
    }

    /**
     * Setter for opcode.
     * @param int opcode
     */
    public function setOpcode($opcode)
    {
        $this->opcode = $opcode;
    }

    /**
     * Getter for isMasked.
     * @return bool isMasked
     */
    public function getIsMasked()
    {
        return $this->isMasked;
    }

    /**
     * Setter for isMasked.
     * @param bool isMasked
     */
    public function setIsMasked(bool $isMasked)
    {
        $this->isMasked = $isMasked;
    }

    /**
     * Getter for length.
     * @return string length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Setter for length.
     * @param string length
     */
    public function setLength(string $length)
    {
        $this->length = $length;
    }

    /**
     * Getter for unmaskedMessage.
     * @return string unmaskedMessage
     */
    public function getUnmaskedMessage()
    {
        return $this->unmaskedMessage;
    }

    /**
     * Setter for unmaskedMessage.
     * @param string unmaskedMessage
     */
    public function setUnmaskedMessage(string $unmaskedMsg)
    {
        $this->unmaskedMessage = $unmaskedMsg;
    }

    /**
     * Getter for maskedMessage.
     * @return string maskedMessage
     */
    public function getMaskedMessage()
    {
        return $this->maskedMessage;
    }

    /**
     * Setter for maskedMessage.
     * @param string maskedMessage
     */
    public function setMaskedMessage(string $maskedMessage)
    {
        $this->maskedMessage = $maskedMessage;
    }

    /**
     * Composes a header from set values.
     * @return string header
     * 
     * TODO: Implement isMarked. Right now ever message ist unmasked.
     */
    public function getHeader()
    {
        $firstByte = $this->getFin();
        $firstByte |= $this->getRsv1();
        $firstByte |= $this->getRsv2();
        $firstByte |= $this->getRsv3();
        $firstByte |= $this->getOpcode();
        $length = strlen($this->getUnmaskedMessage());

        if ($length <= 125)
            $header = pack('CC', $firstByte, $length);
        elseif ($length > 125 && $length < 65536)
            $header = pack('CCn', $firstByte, 126, $length);
        elseif ($length >= 65536)
            $header = pack('CCNN', $firstByte, 127, $length);

        return $header;
    }

    /**
     * Unmasks the masked message and defines the header variables with the
     * value from the mask header.
     */
    public function unmask()
    {
        // First byte
        $firstByte = ord($this->getMaskedMessage()[0]);
        $this->setFin($firstByte & 128);
        $this->setRsv1($firstByte & 64);
        $this->setRsv2($firstByte & 32);
        $this->setRsv3($firstByte & 16);
        $this->setOpcode($firstByte & 15);

        // Second Byte
        $secondByte = ord($this->getMaskedMessage()[1]);
        $this->setIsMasked($secondByte & 128);
        $length = $secondByte & 127;

        $maskedMessage = $this->getMaskedMessage();

        if ($length == 126) {
            $this->setLength(substr($maskedMessage, 2, 2));
            $maskKey = (substr($maskedMessage, 4, 4));
            $unmaskedMessage = (substr($maskedMessage, 8));
        } elseif ($length == 127) {
            $this->setLength(substr($maskedMessage, 2, 8));
            $maskKey = (substr($maskedMessage, 10, 4));
            $unmaskedMessage = (substr($maskedMessage, 14));
        } else {
            $this->setLength($length);
            $maskKey = (substr($maskedMessage, 2, 4));
            $unmaskedMessage = (substr($maskedMessage, 6));
        }

        $maskedMessage = "";

        for ($i = 0; $i < $length; ++$i) {
            $maskedMessage .= $unmaskedMessage[$i] ^ $maskKey[$i % 4];
        }

        $this->setUnmaskedMessage($maskedMessage);
    }

    /**
     * Concats header and unmaskedMessage, saving as masked message.
     * TODO: maskKey as param. Masking the message.
     */
    public function mask()
    {
        $this->setMaskedMessage($this->getHeader() . $this->getUnmaskedMessage());
    }
}
