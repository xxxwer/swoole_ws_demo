<?php

namespace App\View;

class View {
    public function __construct($view_path, $data){
        ob_start();
        $path = __DIR__ . $view_path;
        include($path);
    }

    public function render(){
        return ob_get_contents();
    }

    public function flush(){
        $x = $this->render();
        ob_end_clean();
        return $x;
    }
}
