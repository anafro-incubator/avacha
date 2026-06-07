<?php

declare(strict_types=1);

namespace Avacha\Bay\Language\Compiler\States;

use Avacha\Bay\Language\Exceptions\BaySyntaxException;
use Avacha\Bay\Language\Compiler\Compiler;
use Avacha\Bay\Language\Tokens\HtmlToken;
use Avacha\Support\Strings\ControlledCharacterIterable;
use Override;

class HtmlAttributeCompilerState extends CompilerState
{
    private const HTML_ATTRIBUTE_NAME_REGEX = '/^[a-zA-Z0-9-]+$/';

    public function __construct(
        private readonly HtmlToken $html,
    ) {}

    #[Override]
    public function act(Compiler $compiler, ControlledCharacterIterable $iterable): void
    {
        $iterable->skip(' ', "\t");

        if ($iterable->eol() || $iterable->eos()) {
            $compiler->quitCurrentState();
            return;
        }

        if (!$iterable->matches('/^[a-zA-Z0-9-]$/')) {
            throw new BaySyntaxException("HTML attribute names cannot start with '{$iterable->current()}'.");
        }

        $attributeName = $iterable->collectUntil('=');
        $iterable->skip('=');
        $iterable->skip('"');
        $attributeValue = $iterable->collectUntil('"');
        $iterable->skip('"');

        if (! preg_match(static::HTML_ATTRIBUTE_NAME_REGEX, $attributeName)) {
            throw new BaySyntaxException("'$attributeName' is not a valid HTML attribute name.");
        }

        $this->html->attributes->set($attributeName, $attributeValue);
        $compiler->quitCurrentState();
    }
}
