<?php

namespace App\Core\Http;

class Request
{
    protected $requestStack;

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI']??'/';
        $position  = stripos($path, '?');
        if ($position) {
            return substr($path, 0, $position);
        }
        return $path;
    }
    public function getParams()
    {
        $params = explode('/', $this->getPath());
        array_shift($params);
        return  $params;
    }
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function body()
    {
        $entityBody = file_get_contents('php://input');

        foreach ((array)json_decode($entityBody) as $field => $value) {
            $this->requestStack[$field] = $value;
        }
        return json_decode($entityBody);
    }

    public function input($field)
    {
        $this->body();
        return $this->requestStack[$field];
    }
}
