<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum FeedingType: int
{
    use EnumHelpers;

    case Bottle = 0;
    case Breast = 1;
    case Formula = 2;
}
