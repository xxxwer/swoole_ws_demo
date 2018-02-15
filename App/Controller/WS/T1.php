<?php

namespace App\Controller\WS;

class T1
{
    public function test($request)
    {
        return ['route' => 'T1::test', 'q' => 'qq', 'r' => $request];
    }
}
