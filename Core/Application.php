<?php

namespace App\Core;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;

    private static Container $container;

    public function __construct()
    {
        static::$container = new Container();
        static::$container->set(Request::class, new Request());
        static::$container->set(Response::class, new Response());
        static::$container->set(Router::class,
            new Router(static::$container->get(Request::class),
                static::$container->get(Response::class)
            )
        );
    }

    public function run()
    {
        static::$container->get(Router::class)->resolve(); // запускаем поиск колбэка по реквесту
    }
}
