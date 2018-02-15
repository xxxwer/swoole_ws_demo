<?php

namespace App;

use App\View\View;
use \swoole_websocket_server as swoole_websocket_server;
use App\Lib\Route;

class Kernel {
    public $server;
    public function __construct() {
        $this->init();

        $route = new Route();

        $this->server = new swoole_websocket_server("0.0.0.0", 9501);
        $this->server->on('open', function (swoole_websocket_server $server, $request) {
            echo "server: handshake success with fd{$request->fd}\n";
        });

        $this->server->on('message', function (swoole_websocket_server $server, $frame) use ($route) {
            $data = json_decode($frame->data, true);
            if (empty($data) || empty($data['route'])) {
                $server->push($frame->fd, json_encode(['err' => 'not valid ws msg']));
                return;
            }
            $r = $route->findRoute($data['route']);
            if (empty($r)) {
                $server->push($frame->fd, json_encode(['err' => 'route not find']));
                return;
            }

            $className = $r['class'];
            $method = $r['method'];

            $c = new $className();
            $data = $c->$method($data);

            $data['client_id'] = $frame->fd;
            $server->push($frame->fd, json_encode($data));
            return;
        });

        $this->server->on('close', function ($ser, $fd) {
            echo "client {$fd} closed\n";
        });

        $this->server->on('request', function ($request, $response) {
            $v = new View('/ws_page/index.blade.php', [
                'd' => '++ ws demo ++',
                'request' => $request,
            ]);
            $html = $v->render();
            $response->end($html);
            return;
        });

        $this->server->start();
    }

    public function init(){

    }
}
