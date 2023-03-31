<?php

namespace app\core;

class Request
{
    public function getPath() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        return $path;
    }

    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }
}