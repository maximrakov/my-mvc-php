<?php

namespace App\Core;

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
            (new $pipe)->handle($this->passable);
        }
    }
}
