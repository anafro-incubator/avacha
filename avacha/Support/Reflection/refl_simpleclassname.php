<?php

declare(strict_types=1);

function refl_simpleclassname(string|object $instanceOrClass): string
{
    return new ReflectionClass($instanceOrClass)->getShortName();
}
