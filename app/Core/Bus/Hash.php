<?php

namespace App\Core\Bus;

class Hash
{
    /**
     * Marker to add to signed string
     *
     * @var string
     */
    private static $marker = "yeyrgev746ty4weew";

    /**
     * Hash password with salt and signedString
     *
     * @param string $value
     * @return string
     */
    public static function make(string $value)
    {
        return password_hash(trim(self::signedString(trim($value))), PASSWORD_ARGON2ID);
    }
    /**
     * Verify existing password and new password match
     *
     * @param string $existing
     * @param string $new
     * @return boolean
     */
    public static function check($new, $existing)
    {
        return password_verify(self::signedString(trim($new)), $existing);
    }

    /**
     * Use marker to sign password
     *
     * @param string $value
     * @return string
     */
    private static function signedString(string $value)
    {
        return hash_hmac('sha256', $value, self::$marker);
    }
}
