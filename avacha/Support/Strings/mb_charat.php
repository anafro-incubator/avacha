<?php

declare(strict_types=1);

use Avacha\Exceptions\AvachaException;

function mb_charat(string $string, int $index): string
{
    $len = mb_strlen($string);
    if ($index < 0 || $len <= $index) {
        throw new AvachaException("String index $index is out of range (length = $len)");
    }

    return mb_substr($string, $index, 1);
}
