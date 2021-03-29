<?php

namespace App\Core;

use App\Core\Bus\Router;
use App\Core\Bus\Session;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Middlewares\Kernel;

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

    /**
     *
     * @var object
     */
    public $kernel;

    /**
     *
     * @var object
     */
    public $session;

    /**
     *
     * @var object
     */
    public static  $app;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        self::$app = $this;
        $this->kernel = new Kernel();
        $this->router = new Router($this->request);
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
