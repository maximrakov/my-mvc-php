<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Controller;
use App\Core\Application;

// нужно вынести в отдельный файл хэлперов
function dd()
{
    echo '<pre>';
    $args = func_get_args();
    call_user_func_array('var_dump', $args);
    die();
}

$app = new Application();
$app->router->get('/document/{id}', [Controller::class, 'index']);
$app->router->get('/^\/caba\/ca[xds]a$/', [Controller::class, 'show']);
$app->run();

