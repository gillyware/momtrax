<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum MomTraxUserFeature: string
{
    use EnumHelpers;

    /**
     * **********************************************************************************
     * Pumping
     * **********************************************************************************
     */
    case PumpingEnabled = 'user.pumping_tracking';
    case PumpingPreferStartTime = 'user.pumping_tracking.prefer_start_time';
    case PumpingCountFromStart = 'user.pumping_tracking.count_from_start';

    /**
     * **********************************************************************************
     * Children
     * **********************************************************************************
     */
    case ChildrenEnabled = 'user.children_tracking';
}
