<?php

namespace App\Core;

class Request
{
    public function getPath() // получаем путь реквеста
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        return $path;
    }

    public function getMethod() // получаем тип метода реквеста GET или POST
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
