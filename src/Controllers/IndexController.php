<?php

declare(strict_types=1);

namespace App\Controllers;

use Avacha\Http\Controller;

use function Avacha\Bay\template;

class IndexController extends Controller
{
    public function index(): string
    {
        return template('index', [
            'fruits' => ['Apple', 'Banana', 'Melon', 'Blueberry'],
        ]);
    }
}
