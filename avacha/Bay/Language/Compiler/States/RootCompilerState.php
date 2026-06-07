<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler\States;

use Avacha\Bay\Language\Compiler\Compiler;
use Avacha\Bay\Language\Tokens\TemplateToken;
use Avacha\Bay\Language\Tokens\Token;
use Avacha\Support\Strings\ControlledCharacterIterable;
use Override;

class RootCompilerState extends CompilerState
{
    private readonly TemplateToken $templateToken;

    public function __construct()
    {
        $this->templateToken = new TemplateToken();
    }

    #[Override]
    public function act(Compiler $compiler, ControlledCharacterIterable $iterable): void
    {
        if ($iterable->eos() || $iterable->is('>')) {
            $compiler->quitCurrentState();
            return;
        }

        $compiler->enterState(new LineStartCompilerState($this->templateToken));
    }

    #[Override]
    public function finish(Compiler $compiler): Token
    {
        return $this->templateToken;
    }
}
