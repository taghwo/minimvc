<?php
require __DIR__.'/../vendor/autoload.php';

use App\Core\Application;

$app = new Application();

require_once __DIR__.'/../app/Route.php';

$app->run();
