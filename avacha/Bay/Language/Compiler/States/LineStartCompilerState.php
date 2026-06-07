<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler\States;

use Avacha\Bay\Language\Compiler\HasTokenChildren;
use Avacha\Bay\Language\Compiler\Compiler;
use Avacha\Support\Strings\ControlledCharacterIterable;
use Override;

class LineStartCompilerState extends CompilerState
{
    public function __construct(
        private readonly HasTokenChildren $parent,
    ) {}

    #[Override]
    public function act(Compiler $compiler, ControlledCharacterIterable $iterable): void
    {
        $iterable->skip(" ", "\t", "\n");

        if ($iterable->eos() || $iterable->eol() || $iterable->is(">")) {
            $compiler->quitCurrentState();
            return;
        }

        if ($iterable->is('<')) {
            $compiler->enterState(new HtmlCompilerState($this->parent));
            return;
        }

        if ($iterable->is('=')) {
            $compiler->enterState(new PhpEchoCompilerState($this->parent));
            return;
        }

        $compiler->enterState(new PhpCompilerState($this->parent));
    }
}
