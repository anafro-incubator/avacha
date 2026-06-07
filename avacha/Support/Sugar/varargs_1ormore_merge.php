<?php

declare(strict_types=1);

function varargs_1ormore_merge(mixed $one, mixed ...$more): array
{
    return [$one, ...$more];
}
