<?php
return [
    'Core' => [
        \App\Core\Kernel::class,
        \App\Core\Request::class,
        \App\Core\Response::class,
        \App\Core\Route::class,
        \App\Core\Router::class,
        \App\Core\Middlewares\Middleware::class,
        \App\Controllers\Controller::class,
    ]
];
