<?php

declare(strict_types=1);

namespace Avacha\Http;

use Avacha\Http\Exceptions\ControllerReturnException;

class Controller
{
    public static function call(string $controllerClass, string $controllerMethod, array $variables): Response
    {
        $controllerReturn = call_user_func_array([new $controllerClass, $controllerMethod], $variables);

        if (is_string($controllerReturn)) {
            return new Response($controllerReturn);
        }

        if (is_a($controllerReturn, Response::class)) {
            return $controllerReturn;
        }

        throw ControllerReturnException::whereReturnWas($controllerReturn);
    }
}

