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
            $currentUrlPattern = $urlPattern;
            $argumentNames = [];
            while(strpos($currentUrlPattern, '{')) {
                $openedCurlyBraceIndex = strpos($currentUrlPattern, '{');
                $closedCurlyBraceIndex = strpos($currentUrlPattern, '}');
                $argLength = $closedCurlyBraceIndex - $openedCurlyBraceIndex + 1;
                $curArgumentName = substr($currentUrlPattern, $openedCurlyBraceIndex + 1, $argLength - 2);
                $urlBlockNumber = substr_count($currentUrlPattern, '/', 0, $closedCurlyBraceIndex + 1);
                array_push($argumentNames, [$curArgumentName, $urlBlockNumber]);
                $currentUrlPattern = substr_replace($currentUrlPattern,"\\w+", $openedCurlyBraceIndex, $argLength);
            }
            if(preg_match($currentUrlPattern, $path)) {
                $curIndex = 0;
                for($i = 0; $i < strlen($path); $i++) {
                    $urlBlockNumber = substr_count($path, '/', 0, $i + 1);
                    if($argumentNames[$curIndex][1] == $urlBlockNumber) {
                        $curSubstr = substr($path, $i + 1);
                        $curSubstr = substr($curSubstr, 0, strpos($curSubstr, '/'));
                        array_push($argumentNames[$curIndex], $curSubstr);
                        $curIndex++;
                    }
                }
                $args = [];
                foreach ($argumentNames as $argumentInfo) {
                    array_push($args, $argumentInfo[2]);
                }
                return [$callback, $args];
            }
        }
    }

    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->findCallback($path, $method);

        if (is_array($callback[0])) {
            $callback[0][0] = new $callback[0][0];
        }

        echo call_user_func_array($callback[0], $callback[1]);
    }
}