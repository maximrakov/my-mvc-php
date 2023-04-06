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

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
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

    private function findUrlArguments(int|string $currentUrlPattern): array
    {
        $argumentInfo = [];
        while (strpos($currentUrlPattern, '{')) {
            $openedCurlyBraceIndex = strpos($currentUrlPattern, '{');
            $closedCurlyBraceIndex = strpos($currentUrlPattern, '}'); // находим индексы аргумента

            $currentFunctionArgumentLength = $closedCurlyBraceIndex - $openedCurlyBraceIndex + 1; // вычисляем длину аргумента

            $currentFunctionArgumentName = substr($currentUrlPattern,
                $openedCurlyBraceIndex + 1, $currentFunctionArgumentLength - 2); // находим имя аргумента

            $urlBlockNumber = substr_count($currentUrlPattern, '/',
                0, $closedCurlyBraceIndex + 1); // вычсляем url блок в котором находтся аргумента

            $argumentInfo[] = [$currentFunctionArgumentName, $urlBlockNumber]; // добавляем имя аргумента и номер блока в массив

            $currentUrlPattern = substr_replace($currentUrlPattern, "\\w+",
                $openedCurlyBraceIndex, $currentFunctionArgumentLength); // заменяем все url-аргументы на регулярное выражение
        }
        return [$currentUrlPattern, $argumentInfo]; // возвращаем обработаную регулярку и данные об аргументах
    }

    public function findCallback($path, $method): array
    {
        foreach ($this->routes[$method] as $currentUrlPattern => $callback) { // проходимся по всем паттернам
            $handledUrl = $this->findUrlArguments($currentUrlPattern); // находим все url-аргументы и заменяем их на формат регулярного выражения
            $currentUrlPattern = $handledUrl[0]; // обработаная регулярка
            $argumentInfo = $handledUrl[1]; // информация об аргументах
            if (preg_match($currentUrlPattern, $path)) { // подходит ли url под текущюю регулярку
                $curArgumentNumber = 0; // номер текущего аргумента
                for ($i = 0; $i < strlen($path); $i++) {
                    if ($curArgumentNumber >= count($argumentInfo)) { // если обработали все аргументы выходим
                        break;
                    }
                    $urlBlockNumber = substr_count($path, '/', 0, $i + 1); // считаем номер текущего блока
                    if ($argumentInfo[$curArgumentNumber][1] == $urlBlockNumber) { // если мы находимся в блоке нашего текущего аргумента
                        $curSubstr = substr($path, $i + 1);
                        $curSubstr = substr($curSubstr, 0, strpos($curSubstr, '/'));
                        $argumentInfo[$curArgumentNumber][] = $curSubstr; // добавляем значение этого блока, оно будет значением текущего аргумента
                        $curArgumentNumber++; // переходим к следующему аргументу
                    }
                }
                $args = [];
                foreach ($argumentInfo as $argInfo) { // заполняем массив значениями аргументов
                    $args[] = $argInfo[2];
                }
                return [$callback, $args]; // возвращаем искомый колбэк и аргументы к нему
            }
        }
        return [];
    }
}
