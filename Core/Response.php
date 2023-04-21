<?php

namespace App\Core;

class Response
{
    function header($key, $value): void
    {
        header($key . ': ' . $value);
    }

    function setStatusCode($status): void
    {
        http_response_code($status);
    }
}
