<?php

namespace App\Core;

use App\Core\Bus\Router;
use App\Core\Http\Request;
use App\Core\Http\Response;

class Application
{
    public $router;
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
