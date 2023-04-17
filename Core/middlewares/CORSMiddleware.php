<?php

namespace App\Core\middlewares;

class CORSMiddleware implements Middleware
{

    private $allowedHosts = [];
    public function handle()
    {
        $hostRequest = $_SERVER['REMOTE_ADDR'] + $_SERVER['REMOTE_PORT'];
        if(!in_array($hostRequest, $this->allowedHosts)) {
            return http_response_code(403);
        }
    }
}
