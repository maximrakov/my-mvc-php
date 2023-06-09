<?php

namespace App\Core;

use App\Core\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $entries = [];
    private static $instance;

    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException('Class ' . $id . 'has no binding');
        }
        return $this->entries[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set($id, $obj)
    {
        $this->entries[$id] = $obj;
    }

    public static function setInstance(Container $container)
    {
        static::$instance = $container;
    }

    public static function getInstance() {
        return static::$instance;
    }
}
