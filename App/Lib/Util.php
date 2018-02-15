<?php

namespace App\Lib;

class Util {
    private static $basePath = null;

    public static function basePath($value='')
    {
        if (empty($value)) {
            return self::$basePath;
        }
        self::$basePath = $value;
    }
}
