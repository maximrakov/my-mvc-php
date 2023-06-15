<?php

namespace App\Core;

use App\Core\Middlewares\Middleware;
use Exception;

class Pipeline
{
    private $pipes = [];
    private $passable;

    public function addPipe($pipe)
    {
        $pipes[] = $pipe;
    }

    public function setPipes($pipes)
    {
        $this->pipes = $pipes;
    }

    public function setPassable($passable)
    {
        $this->passable = $passable;
    }

    public function throughPipes()
    {
        foreach ($this->pipes as $pipe) {
            $pipeObj = (new $pipe);
            if (($pipeObj) instanceof Middleware) {
                $pipeObj->handle($this->passable);
            } else {
                throw new Exception('This class is not middleware');
            }
        }
    }
}
