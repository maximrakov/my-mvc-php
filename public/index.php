<?php

require_once __DIR__ . '/../vendor/autoload.php';
use app\core\Application;
use app\controllers\Controller;

$app = new Application();
$app->router->get('/', [Controller::class, 'index']);

$app->run();