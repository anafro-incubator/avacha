<?php

declare(strict_types=1);

namespace Avacha\Assets;

use Avacha\Env\Config;

function link_to_asset(string $asset_path): string
{
    return Config::$assets_url . '/' . $asset_path;
}
