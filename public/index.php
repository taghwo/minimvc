<?php
require __DIR__.'/../vendor/autoload.php';

use App\Core\Application;

$app = new Application();

require_once __DIR__.'/../Route/api.php';

$app->run();
