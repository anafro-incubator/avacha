<?php

declare(strict_types=1);

namespace Avacha\Support\Strings;

use Override;

class ControlledCharacterIterator implements ControlledCharacterIterable
{
    public function __construct(
        private readonly string $string,
        private int $caret = 0,
    ) {}

    #[Override]
    public function current(): ?string
    {
        return $this->eos() ? null : mb_charat($this->string, $this->caret);
    }

    #[Override]
    public function next(): void
    {
        if ($this->caret === mb_strlen($this->string)) {
            return;
        }

        ++$this->caret;
    }

    #[Override]
    public function eos(): bool
    {
        return $this->caret >= mb_strlen($this->string);
    }

    #[Override]
    public function eol(): bool
    {
        return $this->is("\n");
    }

    #[Override]
    public function is(string $character, string ...$more): bool
    {
        $characters = varargs_1ormore_merge($character, ...$more);

        return in_array($this->current(), $characters);
    }

    #[Override]
    public function matches(string $preg): bool
    {
        return preg_match($preg, $this->current()) === 1;
    }

    #[Override]
    public function skip(string $character, string ...$more): void
    {
        while (! $this->eos() && $this->is($character, ...$more)) {
            $this->next();
        }
    }

    #[Override]
    public function collectUntil(string $character, string ...$more): string
    {
        $accumulator = '';

        while (! $this->eos() && ! $this->is($character, ...$more)) {
            $accumulator .= $this->current();
            $this->next();
        }

        return $accumulator;
    }
}
