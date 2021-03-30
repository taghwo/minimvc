<?php

use App\Controllers\Api\AuthenticationController;
use App\Controllers\Api\LoginController;
use App\Controllers\Api\RegisterController;

$app->router->get('/', function () {
    return 'home page';
});

$app->router->post('api/v1/login', [LoginController::class, 'login']);

$app->router->post('api/v1/register', [RegisterController::class, 'register']);

$app->router->get('api/v1/me', [AuthenticationController::class, 'currentuser']);

$app->router->post('api/v1/logout', [AuthenticationController::class, 'logout']);
