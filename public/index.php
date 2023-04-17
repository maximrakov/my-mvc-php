<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Controller;
use App\Core\Application;

$app = new Application();
$app->router->get('#^/document/{id}$#', [Controller::class, 'index']);
$app->router->get('#^/caba/[asd]/daba$#', [Controller::class, 'show']);
$app->run();
