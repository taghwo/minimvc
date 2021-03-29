<?php
namespace App\Core\Exceptions;

use Exception;
use Throwable;
class UnauthenticatedException extends Exception implements Throwable{
    protected $code = 401;
    protected $message;
    public function __construct()
    {
        http_response_code(401);
        $this->message = sprintf('You are not logged in');
    }
}