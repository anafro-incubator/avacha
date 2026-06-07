<?php

declare(strict_types=1);

use Avacha\Http\Kernel;
use Avacha\Http\Request;

set_time_limit(5);
define("BASE_PATH", dirname(__DIR__));
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/boot.php';

$kernel = new Kernel();
define("KERNEL", $kernel);

$request = Request::collect();
$response = $kernel->handle($request);

$response->send();

