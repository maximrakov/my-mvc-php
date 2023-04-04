<?php

namespace app\controllers;

class Controller
{
    public function index($id) {
        return $id;
    }

    public function show() {
        return "yes";
    }
}