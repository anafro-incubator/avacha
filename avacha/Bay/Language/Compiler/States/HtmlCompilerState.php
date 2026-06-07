<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler\States;

use Avacha\Bay\Language\Exceptions\BaySyntaxException;
use Avacha\Bay\Language\Compiler\HasTokenChildren;
use Avacha\Bay\Language\Compiler\Compiler;
use Avacha\Support\Strings\ControlledCharacterIterable;
use Override;

class HtmlCompilerState extends CompilerState
{
    public function __construct(
        private readonly HasTokenChildren $parent,
    ) {}

    #[Override]
    public function act(Compiler $compiler, ControlledCharacterIterable $iterable): void
    {
        if ($iterable->eos()) {
            throw new BaySyntaxException("Html tag start at the end of template");
        }

        if ($iterable->is('<')) {
            $iterable->next();
            $compiler->enterState(new HtmlTagNameCompilerState($this->parent));
            return;
        }

        if ($iterable->is('>')) {
            $iterable->next();
            $compiler->quitCurrentState();
            return;
        }

        $iterable->next();
    }
}
