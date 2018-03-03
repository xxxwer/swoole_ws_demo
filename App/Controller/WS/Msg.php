<?php

namespace App\Controller\WS;

class Msg
{
    public function sendMsg($request)
    {
        $data = $request->getData();
        $data['msg_type'] = 'msg';
        return $data;
    }
}
