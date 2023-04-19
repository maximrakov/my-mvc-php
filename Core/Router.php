<?php

namespace App\Core;

use App\Core\Middlewares\CORSMiddleware;

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
            if (($params = $this->matchUrl($url, $path))) {
                if (!$this->callMiddlewares($route['Middlewares'])) {
                    return;
                }
                echo $this->call($route, $params);
                return;
            }
        }
        $this->response->setStatusCode(404);
    }

    public function callMiddlewares($middlewares)
    {
        foreach ($middlewares as $middleware) {
            if (!call_user_func([new $middleware, 'handle'], $this->request, $this->response)) {
                return false;
            }
        }
        return true;
    }

    private function replacePatterns(mixed $url): string
    {
        return preg_replace('/{.+?}/', '(.+?)', $url);
    }

    private function matchUrl(string $currentUrl, string $url): array|null
    {
        preg_match($currentUrl, $url, $matches);
        if (!empty($matches)) {
            unset($matches[0]);
            if (!$matches) {
                $matches[] = null;
            }
            return $matches;
        }

        return null;
    }

    private function call(mixed $route, mixed $params): string
    {
        return call_user_func_array([new $route['class'], $route['method']], $params);
    }
}
