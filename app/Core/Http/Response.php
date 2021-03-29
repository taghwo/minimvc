<?php

namespace App\Core\Http;

class Response
{
    /**
     * Set status code for response
     *
     * @param integer $code
     */
    public static function setStatus(int $code)
    {
        http_response_code($code);
    }

    /**
     * Return response data in JSON format
     *
     * @param integer $code
     * @param array $data
     * @return json
     */
    public static function json(array $data, $code=417)
    {
        self::setStatus($code);
        return json_encode($data);
    }

      /**
     * Return response data in array format
     *
     * @param integer $code
     * @param array $data
     * @return array
     */
    public static function toArray(array $data, $code=417)
    {
        self::setStatus($code);
        return (array)$data;
    }
}
