<?php

namespace App\Controllers;

use App\Core\Database\DB;

class SimpleController extends Controller
{
    public function index($param)
    {
        print_r(DB::delete('delete from users where name=?', ['artem']));
        $this->view('home', ['name' => $param]);
        return $param;
    }

    public function show()
    {
        return "yes";
    }
}
