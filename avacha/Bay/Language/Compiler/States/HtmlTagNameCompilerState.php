<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler\States;

use Avacha\Bay\Language\Exceptions\BaySyntaxException;
use Avacha\Bay\Language\Compiler\HasTokenChildren;
use Avacha\Bay\Language\Compiler\Compiler;
use Avacha\Bay\Language\Tokens\HtmlToken;
use Avacha\Support\Strings\ControlledCharacterIterable;
use Override;

class HtmlTagNameCompilerState extends CompilerState
{
    private const HTML_TAG_NAME_REGEX = '/^[a-zA-Z0-9-]+$/';

    public function __construct(
        private readonly HasTokenChildren $parent,
    ) {}

    #[Override]
    public function act(Compiler $compiler, ControlledCharacterIterable $iterable): void
    {
        $tagName = $iterable->collectUntil(" ", "\n", "\r");
        if (! preg_match(static::HTML_TAG_NAME_REGEX, $tagName)) {
            throw new BaySyntaxException("'$tagName' is not a valid HTML tag name.");
        }

        $html = new HtmlToken($tagName);
        $compiler->replaceState(new HtmlAttributesCompilerState($this->parent, $html));
    }
}
