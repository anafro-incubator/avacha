<?php

declare(strict_types=1);

namespace Avacha\Bay;

use Avacha\Bay\Language\Compiler\Compiler;

function template(string $name, array $parameters = []): string
{
    extract($parameters);
    $compiler = new Compiler();
    $bay = file_get_contents(BASE_PATH . "/templates/$name.bay");
    $template = $compiler->compile($bay);

    ob_start();
    eval('?>' . $template);
    $html = ob_get_contents();
    ob_clean();

    return $html;
}
