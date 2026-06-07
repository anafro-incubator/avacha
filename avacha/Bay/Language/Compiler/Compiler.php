<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler;

use Avacha\Bay\Language\Compiler\Exceptions\StatelessCompilerException;
use Avacha\Bay\Language\Compiler\States\RootCompilerState;
use Avacha\Bay\Language\Compiler\States\CompilerState;
use Avacha\Support\Strings\ControlledCharacterIterator;
use SplStack;

final class Compiler
{
    public function __construct(
        public readonly SplStack $states = new SplStack(),
    ) {
        //
    }


    public function enterState(CompilerState $newState): void
    {
        $this->states->push($newState);
    }

    public function replaceState(CompilerState $newState): void
    {
        $this->quitCurrentState();
        $this->enterState($newState);
    }

    public function quitCurrentState(): void
    {
        $this->ensureStateful();
        $this->states->pop();
    }

    public function getCurrentState(): CompilerState
    {
        $this->ensureStateful();
        return $this->states->top();
    }

    public function compile(string $template): string
    {
        $initial = new RootCompilerState();
        $iterator = new ControlledCharacterIterator($template);

        $this->enterState($initial);

        while ($this->isStateful()) {
            $state = $this->getCurrentState();
            $state->act($this, $iterator);
        }

        $root = $initial->finish($this);
        return (string) $root;
    }

    private function ensureStateful(): void
    {
        if ($this->isStateful()) {
            return;
        }

        throw new StatelessCompilerException();
    }

    private function isStateful(): bool
    {
        return $this->states->count() !== 0;
    }
}
