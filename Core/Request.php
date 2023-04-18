<?php

namespace App\Core;

class Request
{
    public function getPath() // получаем путь реквеста
    {
        return $this->normalizeUrl(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    public function getMethod() // получаем тип метода реквеста GET или POST
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function normalizeUrl(string|null $url)
    {
        return preg_replace('#^(\#\^/?)(.*?)(/?)$#', '#^/$2', $url);
    }
}
