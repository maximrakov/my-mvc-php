<?php

namespace App\Core\Middlewares;

use App\Core\Request;
use App\Core\Response;

class CORSMiddleware implements Middleware
{
    public function handle(Request $request, Response $response)
    {
        $response->header('access-control-allow-origin', '*');
        return $request;
    }
}
