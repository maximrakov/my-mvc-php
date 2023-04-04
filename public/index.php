<?php

require_once __DIR__ . '/../vendor/autoload.php';
use app\core\Application;
use app\controllers\Controller;

$app = new Application();
$app->router->get('/{id}\/aba/', [Controller::class, 'index']);
$app->router->get('/caba\/ca[xds]a/', [Controller::class, 'show']);
$app->run();

