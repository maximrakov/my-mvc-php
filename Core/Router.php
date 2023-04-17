<?php

namespace App\Core;

class Router
{
    public Request $request;
    protected array $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback): void
    {
        $this->routes['GET'][] = [
            'url' => $this->request->normalizeUrl($path),
            'class' => $callback[0],
            'method' => $callback[1],
        ];
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][] = [
            'url' => $this->request->normalizeUrl($path),
            'class' => $callback[0],
            'method' => $callback[1],
        ];
    }

    public function resolve(): int|bool
    {
        $path = $this->request->getPath(); // получаем путь текущего реквеста
        $method = $this->request->getMethod(); // получаем метод текущего реквеста
        foreach($this->routes[$method] as $route) {
            $url = $this->replacePatterns($route['url']);
            if(($params = $this->matchUrl($url, $path))) {
                echo $this->call($route, $params);
            }
        }

        return http_response_code(404);
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
