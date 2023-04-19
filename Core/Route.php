<?php

namespace App\Core;

class Route
{
    private static $routes = [];

    public static function get($path, $callback, ...$middlewares): void
    {
        self::addRoute('GET', $path, $callback, $middlewares);
    }

    public static function post($path, $callback, ...$middlewares): void
    {
        self::addRoute('POST', $path, $callback, $middlewares);
    }

    private static function addRoute($method, $path, $callback, $middlewares): void
    {
        static::$routes[$method][] = [
            'url' => Request::normalizeUrl($path),
            'class' => $callback[0],
            'method' => $callback[1],
            'Middlewares' => $middlewares,
        ];
    }

    public static function getRoutes()
    {
        return static::$routes;
    }
}
