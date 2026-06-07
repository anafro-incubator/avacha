<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler\States;

use Avacha\Bay\Language\Compiler\Exceptions\CompilerFinishUnsupportedException;
use Avacha\Bay\Language\Compiler\Compiler;
use Avacha\Bay\Language\Tokens\Token;
use Avacha\Support\Strings\ControlledCharacterIterable;

abstract class CompilerState
{
    public function __construct() {}

    abstract public function act(Compiler $compiler, ControlledCharacterIterable $iterable): void;

    public function finish(Compiler $_): Token
    {
        throw CompilerFinishUnsupportedException::whereStateWas($this);
    }

    public function __toString()
    {
        return refl_simpleclassname($this);
    }
}
