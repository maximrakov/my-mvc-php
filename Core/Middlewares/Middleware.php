<?php

namespace App\Core\Middlewares;

use App\Core\Request;
use App\Core\Response;

interface Middleware
{
    public function handle(Request $request, Response $response);
}
