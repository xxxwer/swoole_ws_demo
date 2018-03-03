<?php

namespace App\Lib;

class Request {
    private $onlineUser = [];
    private $data = null;

    public function getOnlineUser() {
        return $this->onlineUser;
    }

    public function addOnlineUser($clientId, $userInfo) {
        $this->onlineUser[$clientId] = $userInfo;
    }

    public function delOnlineUser($clientId) {
        unset($this->onlineUser[$clientId]);
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }
}
