<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Controller;
use App\Core\Application;

$app = new Application();
$app->router->get('/^\/{id}\/{aba}$/', [Controller::class, 'index']);
$app->router->get('/^\/caba\/ca[xds]a$/', [Controller::class, 'show']);
$app->run();

