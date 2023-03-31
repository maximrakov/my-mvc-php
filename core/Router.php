<?php

namespace app\core;

class Router {

    protected array $routes = [];
    public Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function findCallback($path, $method) {

    }

    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->findCallback($path, $method);
        if (is_array($callback)) {
            $callback[0] = new $callback[0];
        }

        echo call_user_func($callback);
    }
}