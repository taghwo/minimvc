<?php

namespace App\Core;

use App\Core\Bus\Router;
use App\Core\Http\Request;
use App\Core\Http\Response;

class Application
{
    /**
     *
     * @var object
     */
    public $router;
    /**
     *
     * @var object
     */
    public $response;
    /**
     *
     * @var object
     */
    public $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    /**
     * Initialise router
     *
     * @return response
     */
    public function run()
    {
        echo $this->router->resolve();
    }
}
