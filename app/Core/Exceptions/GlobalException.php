<?php
namespace App\Core\Exceptions;

use App\Core\Http\Response;


class GlobalException extends BaseException{
    protected $msg;
    protected $code;

    public function __construct($msg,$code=417)
    {
        $this->msg = $msg;
        $this->code = $code;
        parent::__construct();
    }

    public function render()
    {
        return Response::json([
            'status' => "failed",
            "message" =>  $this->msg
        ],$this->code);
    }

}