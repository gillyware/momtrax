<?php

declare(strict_types=1);

namespace App\Enums;

use App\Support\EnumHelpers;

enum MomTraxUserTeam: string
{
    use EnumHelpers;

    /**
     * **********************************************************************************
     * Plan
     * **********************************************************************************
     */
    case Unlimited = 'user.unlimited';
    case Premium = 'user.premium';
}
