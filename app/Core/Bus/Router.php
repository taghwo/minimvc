<?php

namespace App\Core\Bus;

use App\Core\Exceptions\GlobalException;
use App\Core\Http\Request;
use RuntimeException;

class Router
{
    protected $request;
    protected $response;
    protected $path;
    protected $paths;
    protected $route;
    public function __construct(Request $request)
    {
        $this->request = $request;
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
            $this->callback[0] = new $this->callback[0]();
         }
          return call_user_func($this->callback, $this->request);
    }
}
