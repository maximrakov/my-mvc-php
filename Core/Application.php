<?php

namespace App\Core;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct()
    {
        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        $this->router->resolve(); // запускаем поиск колбэка по реквесту
    }
}
