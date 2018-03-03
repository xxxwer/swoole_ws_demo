<?php

namespace App;

use App\View\View;
use \swoole_websocket_server as swoole_websocket_server;
use App\Lib\Route;
use App\Lib\Request;

class Kernel {
    public $server;
    public function __construct() {
        $this->init();

        $route = new Route();
        $request = new Request();
        $dispatch = function($routeStr, $data) use ($route, $request) {
            $r = $route->findRoute($routeStr);

            $className = $r['class'];
            $method = $r['method'];

            $request->setData($data);

            $c = new $className();
            return $c->$method($request);
        };

        $this->server = new swoole_websocket_server("0.0.0.0", 9501);
        $this->server->set([
            'worker_num' => 1,
        ]);


        $this->server->on('open', function (swoole_websocket_server $server, $request) use ($dispatch) {
            echo "server: handshake success with fd{$request->fd}\n";
            $dispatch('open_socket', ['client_id' => $request->fd]);
            return;
        });

        $this->server->on('message', function (swoole_websocket_server $server, $frame) use ($route, $dispatch) {
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

            $data['from'] = $frame->fd;
            $data = $dispatch($data['route'], $data);

            if (empty($data['to'])) {
                return;
            }

            $server->push($data['to'], json_encode($data));

            if (empty($data['all'])) {
                return;
            }

            foreach ($data['all_fd'] as $fd) {
                $server->push($fd, json_encode($data['all']));
            }
            return;
        });

        $this->server->on('close', function ($ser, $fd) use ($dispatch) {
            echo "client {$fd} closed\n";

            $dispatch('close_socket', ['client_id' => $fd]);
            return;
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
