<?php

declare(strict_types=1);

namespace Avacha\Support\Arrays;

function array_areduce(array $array, callable $reducer, mixed $initial = null): mixed
{
    return array_reduce(
        array_keys($array),
        static function ($carry, $key) use ($array, $reducer) {
            $value = $array[$key];
            return $reducer($carry, $key, $value);
        },
        $initial,
    );
}
