<?php

namespace App\Core;

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

    public function get($path, $callback, ...$middleware): void
    {
        $this->addRoute('GET', $path, $callback, $middleware);
    }

    public function post($path, $callback, ...$middleware): void
    {
        $this->addRoute('POST', $path, $callback, $middleware);
    }

    private function addRoute($method, $path, $callback, $middleware): void
    {
        $this->routes[$method][] = [
            'url' => $this->request->normalizeUrl($path),
            'class' => $callback[0],
            'method' => $callback[1],
            'middleware'=> $middleware,
        ];
    }

    public function resolve(): void
    {
        $path = $this->request->getPath(); // получаем путь текущего реквеста
        $method = $this->request->getMethod(); // получаем метод текущего реквеста

        foreach($this->routes[$method] as $route) {
            $url = $this->replacePatterns($route['url']);
            if(($params = $this->matchUrl($url, $path))) {
                if(!$this->callMiddlewares($route['middleware'])) {
                    return;
                }
                echo $this->call($route, $params);
                return;
            }
        }
        $this->response->setStatusCode(404);
   }

   public function callMiddlewares($middlewares) {
       foreach ($middlewares as $middleware) {
           if(!call_user_func([new $middleware, 'handle'], $this->request, $this->response)) {
               return false;
           }
       }
   }
    private function replacePatterns(mixed $url): string
    {
        return preg_replace('/{.+?}/', '(.+?)', $url);
    }

    private function matchUrl(string $currentUrl, string $url): array|null
    {
        preg_match($currentUrl,  $url, $matches);
        if(!empty($matches)) {
            unset($matches[0]);
            if(!$matches) {
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
