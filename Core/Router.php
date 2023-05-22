<?php

namespace App\Core;

use App\Core\Middlewares\TrustedHostsMiddleware;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function resolve(): void
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $routes = Route::getRoutes();
        foreach ($routes[$method] as $route) {
            $url = $this->replacePatterns($route['url']);
            if (preg_match($this->addPregBorders($url), $path)) {
                echo $this->call($route, $this->findParameters($url, $path));
                return;
            }
        }
        $this->response->setStatusCode(404);
    }

    private function replacePatterns(mixed $url): string
    {
        return preg_replace('/{.+?}/', '(.+?)', $url);
    }

    private function findParameters(string $currentUrl, string $url): array
    {
        preg_match($this->addPregBorders($currentUrl), $url, $matches);
        unset($matches[0]);
        return $matches;
    }

    private function call(mixed $route, array $params): string
    {
        return call_user_func_array([new $route['class'], $route['method']], $params);
    }

    private function addPregBorders(string $pattern): string
    {
        return '#^' . $pattern . '$#';
    }
}
