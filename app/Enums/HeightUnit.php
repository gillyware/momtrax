<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum HeightUnit: string
{
    use EnumHelpers;

    case Inches = 'in';
    case Centimeters = 'cm';
}
