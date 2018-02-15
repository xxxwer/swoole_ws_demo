<?php

require_once __DIR__ . '/../App/Lib/Autoloader.php';

use App\Kernel;
use App\Lib\Util;

Util::basePath(__DIR__ . '/..');
new Kernel();
