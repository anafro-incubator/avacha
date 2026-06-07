<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Tokens;

use Avacha\Bay\Language\Compiler\HasTokenChildren;
use Avacha\Bay\Language\Tokens\Token;
use Avacha\Support\Html\HtmlAttributes;
use Override;

class HtmlToken extends Token implements HasTokenChildren
{
    public function __construct(
        public string $tagName,
        public protected(set) array $children = [],
        public readonly HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    #[Override]
    public function children(): array
    {
        return $this->children;
    }

    #[Override]
    public function appendChild(Token $child): void
    {
        $this->children[] = $child;
    }

    public function __toString()
    {
        $body = implode(PHP_EOL, $this->children);

        return "
        echo '<$this->tagName $this->attributes>';
        {$body}
        echo '</$this->tagName>';
        ";
    }
}
