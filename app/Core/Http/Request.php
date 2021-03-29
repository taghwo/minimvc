<?php

namespace App\Core\Http;

use App\Core\Application;
use App\Core\Exceptions\GlobalException;

class Request
{
    /**
     * Holds array key pairs for post data
     *
     * @var array
     */
    protected $requestStack;

    /**
     * Get server request path
     *
     * @return string
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI']??'/';
        $position  = stripos($path, '?');
        if ($position) {
            return substr($path, 0, $position);
        }
        return $path;
    }

    /**
     * Get server request method
     *
     * @return string
     */
    public function getParams()
    {
        $params = explode('/', $this->getPath());
        array_shift($params);
        return  $params;
    }

    public function session(){
        return Application::$app->session;
    }
    /**
     * Get server request method
     *
     * @return string
     */
    public static function getBearer()
    {
        $token = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
        if(isset($token[1])){
            return  $token[1];
        }
        throw new GlobalException("Authorization bearer token not found in HTTP_AUTHORIZATION  header");
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Get post request body
     *
     * @return object
     */
    public function body()
    {
        $entityBody = file_get_contents('php://input');

        foreach ((array)json_decode($entityBody) as $field => $value) {
            $this->requestStack[$field] = $value;
        }
        return json_decode($entityBody);
    }

    /**
     * Get formatted post request body
     * @return string $field
     * @return string
     */
    public function input(string $field)
    {
        $this->body();
        return $this->requestStack[$field];
    }
}
