<?php

declare(strict_types=1);

namespace App\Enums;

use App\Support\EnumHelpers;

enum Appearance: string
{
    use EnumHelpers;

    case System = 'system';
    case Light = 'light';
    case Dark = 'dark';
    case Green = 'theme-green';
    case Mauve = 'theme-mauve';
    case Purple = 'theme-purple';
    case Blue = 'theme-blue';
    case Orange = 'theme-orange';
}
