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
        foreach ($this->routes[$method] as $urlPattern => $callback) {
            $cur_url = $urlPattern;
            $argumentNames = [];
            while(strpos($cur_url, '{')) {
                $openedCurlyBraceIndex = strpos($cur_url, '{');
                $closedCurlyBraceIndex = strpos($cur_url, '}');
                $argLength = $closedCurlyBraceIndex - $openedCurlyBraceIndex + 1;
                $curArgument = substr($cur_url, $openedCurlyBraceIndex + 1, $argLength - 1);
                $urlBlockNumber = substr_count($cur_url, '\\', 0, $closedCurlyBraceIndex + 1);
                array_push($argumentNames, [$curArgument, $urlBlockNumber]);
                $cur_url = substr_replace($cur_url,"\w+", $openedCurlyBraceIndex, $argLength);
            }
            if(preg_match($cur_url, $path)) {
                $curIndex = 0;
                for($i = 0; $i < strlen($path); $i++) {
                    $urlBlockNumber = substr_count($path, '\\', 0, $i + 1);
//                    if($argumentNames[$curIndex] == )
                }
            }
        }
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