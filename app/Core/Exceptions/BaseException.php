<?php
namespace App\Core\Exceptions;

use Exception;
use Throwable;

abstract class BaseException extends Exception implements Throwable,ExceptionInterface {

    public function __construct()
    {
        @set_exception_handler(array($this,'unhandledException'));
    }


     /**
     * Handle undhandled exceptions
     *
     * @return response
     */
    public function unhandledException($e)
    {
        echo $e->render();
    }
}