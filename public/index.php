<?php

use App\Core\Application;
use App\Core\middlewares\CORSMiddleware;
use App\Core\Route;

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../routes/web.php';


$app = new Application();
$app->run();
