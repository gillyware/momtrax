<?php

declare(strict_types=1);

namespace App\Enums;

use App\Support\EnumHelpers;

enum MomTraxTeam: string
{
    use EnumHelpers;

    case Unlimited = 'unlimited';
    case Premium = 'premium';
}
