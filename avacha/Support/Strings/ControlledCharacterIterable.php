<?php

declare(strict_types=1);

namespace Avacha\Support\Strings;

interface ControlledCharacterIterable
{
    public function current(): ?string;
    public function next(): void;
    public function is(string $character, string ...$more): bool;
    public function matches(string $preg): bool;
    public function skip(string $character, string ...$more): void;
    public function eos(): bool;
    public function eol(): bool;
    public function collectUntil(string $character, string ...$more): string;
}
