<?php

namespace App\Controllers;

class Controller
{
    public function view($view, $parameters)
    {
        foreach ($parameters as $key => $value) {
            $$key = $value;
        }
        include_once "../views/$view.php";
    }
}
