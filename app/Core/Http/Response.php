<?php

namespace App\Core\Http;

class Response
{
    public static function setStatus($code)
    {
        http_response_code($code);
    }

    public static function json(array $data, $code=417)
    {
        self::setStatus($code);
        return json_encode($data);
    }

    public static function toArray(array $data, $code=417)
    {
        self::setStatus($code);
        return (array)$data;
    }
}
