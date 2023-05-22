<?php

namespace App\Core\Middlewares;

use App\Core\Request;
use App\Core\Response;

class CORSMiddleware implements Middleware
{
    public function handle($request)
    {
        app()->get(Response::class)
            ->header('access-control-allow-origin', '*');
    }
}
