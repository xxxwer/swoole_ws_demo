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

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
