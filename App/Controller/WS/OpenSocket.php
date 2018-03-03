<?php

namespace App\Controller\WS;

use App\Lib\Util;

class OpenSocket
{
    private static $onlineUser = [];

    public static function add($request)
    {

        $clientId = $request->getData()['client_id'];
        $userInfo = [
            'userName' => Util::generateRandomString(8),
            'avatar' => rand(2,3),
            'fd' => $clientId,
        ];
        $request->addOnlineUser($clientId, $userInfo);
    }

    public static function del($request)
    {
        $clientId = $request->getData()['client_id'];
        $request->delOnlineUser($clientId);
    }

    public function init($request)
    {
        $onlineUser = $request->getOnlineUser();
        $userParam = $request->getData();
        $fd = $userParam['from'];
        $list = $onlineUser;
        unset($list[$fd]);
        $data = [
            'msg_type' => 'init',
            'my' => $onlineUser[$fd],
            'user_list' => $list,
            'from' => $fd,
            'to' => $fd,
            'all' => ['msg_type' => 'new_user', 'user_info' => $onlineUser[$fd]],
            'all_fd' => array_keys($list),
        ];
        return $data;
    }
}
