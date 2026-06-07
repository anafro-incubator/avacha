<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Tokens;

class PhpToken extends Token
{
    public function __construct(
        public readonly string $code
    ) {}

    public function __toString()
    {
        return <<<PHP
            $this->code
        PHP;
    }
}
