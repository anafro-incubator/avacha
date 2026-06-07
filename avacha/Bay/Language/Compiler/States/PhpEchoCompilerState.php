<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler\States;

use Avacha\Bay\Language\Compiler\Compiler;
use Avacha\Bay\Language\Compiler\HasTokenChildren;
use Avacha\Bay\Language\Tokens\PhpToken;
use Avacha\Support\Strings\ControlledCharacterIterable;
use Override;

class PhpEchoCompilerState extends CompilerState
{
    public function __construct(
        private readonly HasTokenChildren $parent,
    ) {}

    #[Override]
    public function act(Compiler $compiler, ControlledCharacterIterable $iterable): void
    {
        $iterable->skip("=");
        $expression = $iterable->collectUntil("\n");
        $code = "echo $expression;";
        $php = new PhpToken($code);
        $this->parent->appendChild($php);
        $compiler->quitCurrentState();
    }
}
