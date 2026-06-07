<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Exceptions;

use Throwable;

class BaySyntaxException extends BayException
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
