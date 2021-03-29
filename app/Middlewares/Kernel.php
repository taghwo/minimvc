<?php
namespace App\Middlewares;

class Kernel{
    protected $globalMiddlewares;
    protected $request;

    public static function globalMiddleware(){
        return [
            "auth" => [Auth::class]
        ];
    }
}