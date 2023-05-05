<?php

namespace App\Controllers;

use App\Core\Database\DB;
use App\Core\Database\User;
use App\Core\View;

class SimpleController extends Controller
{
    public function index($param)
    {
        View::make('home', ['name' => 'ivan']);
        return $param;
    }

    public function show()
    {
        return "yes";
    }
}
