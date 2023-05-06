<?php

namespace App\Core;

class View
{
    public static function make($templateName, $parameters)
    {
        foreach ($parameters as $key => $value) {
            $$key = $value;
        }
        include_once static::templateLocation($templateName);
    }

    public static function exists($templateName)
    {
        return file_exists(static::templateLocation($templateName));
    }

    public static function first($templateNames, $parameters)
    {
        foreach ($templateNames as $templateName) {
            if (static::exists($templateName)) {
                static::make($templateName, $parameters);
                return;
            }
        }
    }

    private static function templateLocation($templateName): string
    {
        return "../views/$templateName.php";
    }
}
