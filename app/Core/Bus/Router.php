<?php

namespace App\Core\Bus;

use App\Core\Http\Request;
use App\Core\Http\Response;
use RuntimeException;

class Router
{
    protected $request;
    protected $response;
    protected $path;
    protected $paths;
    protected $route;
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        if (substr($path, 0, 1) !== '/' || substr($path, 0, 1) !== "/") {
            $path = '/'.$path;
        }
        $this->paths['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        if (substr($path, 0, 1) !== '/' || substr($path, 0, 1) !== "/") {
            $path = '/'.$path;
        }
        $this->paths['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $this->callback = $this->paths[$method][$path]??false;
        if (!$this->callback) {
            $methodToUpper = strtoupper($method);
            throw new RuntimeException("The  {$methodToUpper} request for {$this->request->getPath()} did not match any route.");
        }
        return $this->loadApp();
    }

    private function loadApp()
    {
        if (is_array($this->callback)) {
            try {
                $this->callback[0] = new $this->callback[0]();
            } catch (\Exception $e) {
                die("{$this->callback[1]} method does not exist in {$this->callback[0]}");
            }
        }

        return call_user_func($this->callback, $this->request);
    }
}
