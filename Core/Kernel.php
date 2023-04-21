<?php

namespace App\Core;

use App\Core\Middlewares\CORSMiddleware;
use App\Core\Middlewares\TrustedHostsMiddleware;

class Kernel
{
    protected static $globalMiddlewares = [
        CORSMiddleware::class
    ];

    public static function runGlobalMiddlewares($request, $response)
    {
        foreach (static::$globalMiddlewares as $middleware) {
            $middlewareInstance = new $middleware;
//            dd($middlewareInstance);
            $request = call_user_func([$middlewareInstance, 'handle'], $request, $response);
        }
        return $request;
    }
}
