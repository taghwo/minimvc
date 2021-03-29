<?php
namespace App\Core\Exceptions;

use App\Core\Http\Response;


class ValidationException extends BaseException{
    protected $code = 400;
    protected $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
        parent::__construct();
    }

    public function render()
    {
        return Response::json([
            'status' => "failed",
            "errors" =>  $this->errors
        ],$this->code);
    }

}