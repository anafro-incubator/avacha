<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler;

use Avacha\Bay\Language\Tokens\Token;

interface HasTokenChildren
{
    public function children(): array;
    public function appendChild(Token $child): void;
}
