<?php

namespace App\Core;

class Application extends Container
{
    public function __construct()
    {
        static::setInstance($this);
        $this->registerBaseBindings();
    }

    public function registerBaseBindings(): void
    {
        $this->set(Request::class, new Request());
        $this->set(Response::class, new Response());
        $this->set(Router::class,
            new Router($this->get(Request::class),
                $this->get(Response::class)
            )
        );
    }
}
