<?php

namespace App\Controllers;

use App\Core\Database\DB;
use App\Core\Database\User;

class SimpleController extends Controller
{
    public function index($param)
    {
        return $param;
    }

    public function show()
    {
        return "yes";
    }
}
