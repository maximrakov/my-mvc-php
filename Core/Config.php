<?php

namespace App\Core;

class Config
{
    public static function get($path)
    {
        $elements = explode('.', $path);
        $configArray = require_once(__DIR__ . "/../config/$elements[0].php");
        $arrayDimensions = '';
        for ($i = 1; $i < count($elements); $i++) {
            $arrayDimensions .= "['" . $elements[$i] . "']";
        }
        $name = '$configArray' . $arrayDimensions;
        return eval("return $name;");
    }
}
