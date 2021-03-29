<?php

namespace App\Middlewares;

interface MiddlewareContract
{
    public function handle($args1='',$args2='');
}