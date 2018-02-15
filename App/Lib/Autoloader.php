<?php

namespace App\Lib;

class Autoloader {
    static public function loader($className) {
        $filename = __DIR__ . "/../../" . str_replace("\\", '/', $className) . ".php";
        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

spl_autoload_register('App\Lib\Autoloader::loader');
