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

        $this->route[] = ['t' => 1, 'url' => 'init', 'class' => 'App\Controller\WS\OpenSocket', 'method' => 'init'];
        $this->route[] = ['t' => 1, 'url' => 'open_socket', 'class' => 'App\Controller\WS\OpenSocket', 'method' => 'add'];
        $this->route[] = ['t' => 1, 'url' => 'close_socket', 'class' => 'App\Controller\WS\OpenSocket', 'method' => 'del'];
        $this->route[] = ['t' => 1, 'url' => 'send_msg', 'class' => 'App\Controller\WS\Msg', 'method' => 'sendMsg'];
    }

    protected function setRouteGroup()
    {
        $this->routeGroup = 'ws';
    }
}
