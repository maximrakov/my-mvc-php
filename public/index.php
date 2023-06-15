<?php

use App\Core\Application;
use App\Core\Database\User;
use App\Core\middlewares\TrustedHostsMiddleware;
use App\Core\Route;
use \App\Core\Kernel;

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../routes/web.php';

$app = new Application();
$app->set(Kernel::class, new Kernel());
$kernel = $app->get(Kernel::class);
$kernel->handle();
