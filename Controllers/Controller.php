<?php

namespace App\Controllers;

use App\Core\Database\DB;
use App\Core\View;

class Controller
{
    public function view($view, $parameters)
    {
        View::make($view, $parameters);
    }
}
