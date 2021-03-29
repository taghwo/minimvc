<?php

namespace App\Core\Bus;

class Hash
{
    private static $marker = "yeyrgev746ty4weew";

    public static function make($value)
    {
        return password_hash(trim(self::signedString(trim($value))), PASSWORD_ARGON2ID);
    }
    public static function check($new, $existing)
    {
        return password_verify(self::signedString(trim($new)), $existing);
    }

    private static function signedString($value)
    {
        return hash_hmac('sha256', $value, self::$marker);
    }
}
