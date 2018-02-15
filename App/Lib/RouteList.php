<?php

namespace App\Lib;

abstract class RouteList
{
    protected $route = [];
    protected $routeGroup = '';

    public function __construct()
    {
        $this->defineRoute();
        $this->setRouteGroup();
    }

    abstract protected function defineRoute();
    abstract protected function setRouteGroup();

    public function getRoute()
    {
        foreach ($this->route as $key => $value) {
            $this->route[$key]['routeGroup'] = $this->routeGroup;
        }
        return $this->route;
    }

    public function getRouteGroup()
    {
        return $this->routeGroup;
    }
}
