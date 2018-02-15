<?php

namespace App\Route;

use App\Lib\RouteList;

class WS extends RouteList
{
    protected function defineRoute()
    {
        /*
            ['t' => 1, ...];
            t为1时，用字符串全等匹配
            ['t' => 2, ...];
            t为2时，用正则执行匹配
        */

        // swagger api json
        $this->route[] = ['t' => 1, 'url' => 'ws_test1', 'class' => 'App\Controller\WS\T1', 'method' => 'test'];
    }

    protected function setRouteGroup()
    {
        $this->routeGroup = 'ws';
    }
}
