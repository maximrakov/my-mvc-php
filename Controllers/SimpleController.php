<?php

namespace App\Controllers;

class SimpleController extends Controller
{
    public function index($param)
    {
        $this->view('home', ['name' => $param]);
        return $param;
    }

    public function show()
    {
        return "yes";
    }
}
