<?php

use App\Controller\Api\AuthenticationController;
use App\Controller\Api\LoginController;
use App\Controller\Api\RegisterController;

$app->router->get('/', function () {
    return 'home page';
});

$app->router->post('v1/api/login', [LoginController::class, 'login']);

$app->router->post('v1/api/register', [RegisterController::class, 'register']);

$app->router->get('v1/api/me', [AuthenticationController::class, 'currentuser']);

$app->router->post('v1/api/logout', [AuthenticationController::class, 'logout']);
