<?php

namespace App\Core;

use function PHPUnit\Framework\isEmpty;

class Request
{
    private array $headers = [];

    public function getPath(): array|string|null
    {
        return $this->normalizeUrl(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    public function getHeaders(): array
    {
        if (!$this->headers) {
            $this->headers = $_SERVER;
        }
        return $this->headers;
    }

    public function getHeader($key) {
        return $this->getHeaders()[$key];
    }

    public function addHeader($key, $value): void
    {
        $this->getHeaders();
        $this->headers[$key] = $value;
    }

    public function removeHeader($key): void
    {
        $this->getHeaders();
        unset($this->headers[$key]);
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function normalizeUrl(string|null $url): array|string|null
    {
        return preg_replace('#^(/?)(.*?)(/?)$#', '/$2', $url);
    }
}
