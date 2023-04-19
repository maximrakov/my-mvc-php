<?php

namespace App\Core;

class Request
{
    public function getPath()
    {
        return $this->normalizeUrl(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function normalizeUrl(string|null $url)
    {
        return preg_replace('#^(\#\^/?)(.*?)(/?)$#', '#^/$2', $url);
    }
}
