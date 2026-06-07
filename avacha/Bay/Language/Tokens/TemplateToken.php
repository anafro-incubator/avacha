<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Tokens;

use Avacha\Bay\Language\Compiler\HasTokenChildren;
use Avacha\Bay\Language\Tokens\Token;
use Override;

class TemplateToken extends Token implements HasTokenChildren
{
    public function __construct(
        public protected(set) array $children = [],
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
        $bay = implode("\n", $this->children);
        return "<?php
            $bay
        ?>";
    }
}
