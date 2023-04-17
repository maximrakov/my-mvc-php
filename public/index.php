<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Controller;
use App\Core\Application;
use App\Core\middlewares\CORSMiddleware;

$app = new Application();
$app->router->get('#^/document/{id}$#', [Controller::class, 'index'], CORSMiddleware::class);
$app->router->get('#^/caba/[asd]/daba$#', [Controller::class, 'show'], CORSMiddleware::class);
$app->run();
