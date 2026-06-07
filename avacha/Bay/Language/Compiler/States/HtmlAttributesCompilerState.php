<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler\States;

use Avacha\Bay\Language\Exceptions\BaySyntaxException;
use Avacha\Bay\Language\Compiler\HasTokenChildren;
use Avacha\Bay\Language\Compiler\Compiler;
use Avacha\Bay\Language\Tokens\HtmlToken;
use Avacha\Support\Strings\ControlledCharacterIterable;
use Override;

class HtmlAttributesCompilerState extends CompilerState
{
    public function __construct(
        private readonly HasTokenChildren $parent,
        private readonly HtmlToken $html,
    ) {}

    #[Override]
    public function act(Compiler $compiler, ControlledCharacterIterable $iterable): void
    {
        $iterable->skip(' ', "\t", "\r");

        if ($iterable->eos()) {
            throw new BaySyntaxException("Html tag {$this->html->tagName} was not closed.");
        }

        if ($iterable->eol()) {
            $this->parent->appendChild($this->html);
            $iterable->next();
            $compiler->enterState(new LineStartCompilerState($this->html));
            return;
        }

        if ($iterable->is('>')) {
            $compiler->quitCurrentState();
            return;
        }

        $compiler->enterState(new HtmlAttributeCompilerState($this->html));
    }
}
