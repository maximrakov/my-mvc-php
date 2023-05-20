<?php

namespace App\Core;

use App\Core\Middlewares\TrustedHostsMiddleware;

class Kernel
{
    protected $middleware = [];

    public function handle()
    {
        $this->sendRequestThroughRouter();
    }

    public function sendRequestThroughRouter()
    {
        $request = app()->get(Request::class);
        $this->sendRequestThroughMiddlewares($request);
        app()->get(Router::class)
            ->resolve();
    }

    public function sendRequestThroughMiddlewares($request)
    {
        $pipeline = new Pipeline();
        $pipeline->setPassable($request);
        $pipeline->setPipes($this->middleware);
        $pipeline->throughPipes();
    }
}
