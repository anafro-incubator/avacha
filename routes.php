<?php

declare(strict_types=1);

use App\Controllers\IndexController;
use Avacha\Http\Request;
use Avacha\Http\Route;

return [
    new Route(
        method: Request::GET,
        path: '/',
        handler: [IndexController::class, 'index']
    ),
];

