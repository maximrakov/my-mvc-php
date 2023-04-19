<?php

namespace App\Core;

class Response
{
    function header($key, $value)
    {
        header($key . ': ' . $value);
    }

    function setStatusCode($status)
    {
        http_response_code($status);
    }
}
