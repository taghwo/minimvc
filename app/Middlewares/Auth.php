<?php

namespace App\Middlewares;

use App\Core\Exceptions\UnauthenticatedException;
use App\Core\Http\Request;

class Auth extends Kernel
{
    public function handle(Request $request)
    {
        if(!$request->session()->check()){
            throw new UnauthenticatedException();
        }
    }
}