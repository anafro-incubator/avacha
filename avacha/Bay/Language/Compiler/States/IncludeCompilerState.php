<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler\States;

use Avacha\Bay\Language\Compiler\Compiler;
use Avacha\Bay\Language\Compiler\HasTokenChildren;
use Avacha\Bay\Language\Tokens\PhpToken;
use Avacha\Support\Strings\ControlledCharacterIterable;
use Override;

class IncludeCompilerState extends CompilerState
{
    public function __construct(
        private readonly HasTokenChildren $parent,
    ) {}

    #[Override]
    public function act(Compiler $compiler, ControlledCharacterIterable $iterable): void
    {
        $iterable->skip('@');
        $filename = $iterable->collectUntil("\n");
        $path = BASE_PATH . "/templates/$filename.bay";
        $bay = file_get_contents($path);
        $inclusionCompiler = new Compiler();
        $inclusionTemplate = $inclusionCompiler->compileToToken($bay);
        $this->parent->appendChild($inclusionTemplate);
        $compiler->quitCurrentState();
    }
}
