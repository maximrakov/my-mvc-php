<?php

namespace App\Core;

use App\Core\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $entries = [];

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
}
