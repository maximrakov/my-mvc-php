<?php

namespace App\Core\Middlewares;

use App\Core\Request;
use App\Core\Response;

class CORSMiddleware implements Middleware
{
    private $allowedHosts = [];

    public function handle(Request $request, Response $response)
    {
        $requestHost = $_SERVER['REMOTE_ADDR'] . ':' . $_SERVER['REMOTE_PORT'];
        if (!in_array($requestHost, $this->allowedHosts)) {
            $response->setStatusCode(403);
            return false;
        }
    }
}
