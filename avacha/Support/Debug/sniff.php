<?php

declare(strict_types=1);

function sniff(mixed $value, mixed $notes = ""): mixed
{
    if (headers_sent()) {
        return $value;
    }

    if (is_callable($notes)) {
        $notes = $notes($value);
    }

    echo "<br><i><b>Sniffed:</b> '$value' (notes: '$notes')</i>";
    return $value;
}
