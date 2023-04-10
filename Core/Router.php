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
        $handledPathAndUrlArgs = $this->handlePatternArguments($path);
        $this->routes['GET'][$handledPathAndUrlArgs[0]] = [$callback, $handledPathAndUrlArgs[1]];
    }

    public function handlePatternArguments($path): array
    {
        preg_match_all('/\{(\w+)\}/', $path, $urlArguments); // находим url аргументы
        $blockNumbers = [];
        foreach ($urlArguments[0] as $urlArgument) { // проходимся по url аргументам
            $argPosition = strpos($path, $urlArgument); // ищем индекс вхождения первого аргумента
            $blockNumbers[] = substr_count($path, '/', 0, $argPosition) - 1; // добавляем номер url-блока в котором находится текущий url - аргумент
            $path = str_replace($urlArgument, '\w+', $path); // заменяем url-аргмента на w+ для валидной регулярки
        }
        return [$path, $blockNumbers];
    }

    public function post($path, $callback)
    {
        $handeledPathAndUrlArgs = $this->handlePatternArguments($path);
        $this->routes['POST'][$handeledPathAndUrlArgs[0]] = [$callback, $handeledPathAndUrlArgs[1]];
    }

    public function resolve()
    {
        $path = $this->request->getPath(); // получаем путь текущего реквеста
        $method = $this->request->getMethod(); // получаем метод текущего реквеста

        $callback = $this->findCallback($path, $method); // ищем колбэк по методу и пути
        if (count($callback) == 0) { // если колбэк по реквусту не нашли, отдаем 404
            http_response_code(404);
        }

        $callback[0][0] = new $callback[0][0](); // создаем экземпляр контроллера

        echo call_user_func_array($callback[0], $callback[1]); // вызываем метод с аргументами
    }

    public function findCallback($path, $method)
    {
        foreach ($this->routes[$method] as $pattern => $callbackAndArgs) { // проходимся по url-паттернам
            if (preg_match($pattern, $path)) { // смотрим матчится ли текущий паттерн с url-путем
                $urlBlocks = explode('/', $path); // разбиваем url на url-блоки
                $args = [];
                foreach ($callbackAndArgs[1] as $urlBlockNumber) {
                    $args[] = $urlBlocks[$urlBlockNumber]; // добавляем значение url-аргумента
                }
                return [$callbackAndArgs[0], $args];
            }
        }
        return [];
    }
}
