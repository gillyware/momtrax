<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum MilkUnit: string
{
    use EnumHelpers;

    case Millis = 'ml';
    case Ounces = 'oz';
}
