<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum WeightUnit: string
{
    use EnumHelpers;

    case Pounds = 'lbs';
    case Kilos = 'kg';
}
