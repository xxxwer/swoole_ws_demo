<?php

namespace App\Lib;

use Exception;

class Route {
    protected $allRoute = [];
    protected $classFile = [
        'App\Route\WS',
    ];

    public function loadClassRoute()
    {
        foreach ($this->classFile as $className) {
            $r = new $className();
            $this->allRoute = array_merge($this->allRoute, $r->getRoute());
        }
    }

    public function findRoute($routeStr)
    {
        $this->loadClassRoute();
        foreach ($this->allRoute as $key => $route) {
            $r = $this->compareRoute($routeStr, $route);
            if ($r) {
                return $route;
            }
        }
        return false;
    }

    private function compareRoute($routeStr, $route)
    {
        if ($route['t'] == 1 && $route['url'] === $routeStr) {
            return true;
        } elseif ($route['t'] == 2 && preg_match_all($route['url'], $routeStr, $matches) === 1) {
            return true;
        }
        return false;
    }
}
