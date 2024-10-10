<?php

namespace PixPhp;

class StaticPix
{
    public static function formatField($id, $value)
    {
        return $id . str_pad(strlen($value), 2, '0', STR_PAD_LEFT) . $value;
    }

    public static function calculateCRC16($data)
    {
        $result = 0xFFFF;
        for ($i = 0; $i < strlen($data); $i++) {
            $result ^= (ord($data[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if ($result & 0x8000) {
                    $result = ($result << 1) ^ 0x1021;
                } else {
                    $result <<= 1;
                }
                $result &= 0xFFFF;
            }
        }
        return strtoupper(str_pad(dechex($result), 4, '0', STR_PAD_LEFT));
    }

    public static function generatePix($key, $idTx = '', $amount = 0.00, $description = '')
    {
        $result = "000201";
        $result .= self::formatField("26", "0014br.gov.bcb.pix" . self::formatField("01", PixKey::formatKey($key)));

        // Description field (if provided)
        if (!empty($description)) {
            $result .= self::formatField("02", $description);
        }

        $result .= "52040000"; // Fixed code
        $result .= "5303986";  // Currency (Real)
        if ($amount > 0) {
            $result .= self::formatField("54", number_format($amount, 2, '.', ''));
        }
        $result .= "5802BR"; // Country
        $result .= "5901N";  // Name
        $result .= "6001C";  // City

        $result .= self::formatField("62", self::formatField("05", $idTx ?: '***'));

        $result .= "6304"; // Start of CRC16
        $result .= self::calculateCRC16($result); // Add CRC16 at the end
        return $result;
    }
}
