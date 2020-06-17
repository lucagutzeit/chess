<?php
class MessageHandler
{
    public static function mask($msg)
    {
        $b1 = 0x80 | (0x1 & 0x0f);
        $length = strlen($msg);

        if ($length <= 125)
            $header = pack('CC', $b1, $length);
        elseif ($length > 125 && $length < 65536)
            $header = pack('CCn', $b1, 126, $length);
        elseif ($length >= 65536)
            $header = pack('CCNN', $b1, 127, $length);

        printf("Masked message:%s%s\n", $header, $msg);
        return $header . $msg;
    }

    public static function unmask($msg)
    {
        $length = ord($msg[1]) & 127;
        if ($length == 126) {
            $masks = substr($msg, 4, 4);
            $data = substr($msg, 8);
        } elseif ($length == 127) {
            $masks = substr($msg, 10, 4);
            $data = substr($msg, 14);
        } else {
            $masks = substr($msg, 2, 4);
            $data = substr($msg, 6);
        }
        $msg = "";
        for ($i = 0; $i < strlen($data); ++$i) {
            $msg .= $data[$i] ^ $masks[$i % 4];
        }

        printf("Unmasked message:%s\n", $msg);
        return $msg;
    }
}
