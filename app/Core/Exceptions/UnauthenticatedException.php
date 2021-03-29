<?php
namespace App\Core\Exceptions;

use App\Core\Http\Response;

class UnauthenticatedException extends BaseException{
    protected $code = 401;
    protected $message = 'You are not logged in';


    public function render()
    {
        return Response::json([
            'status' => "failed",
            "meesage" => $this->message
        ]);
    }

}