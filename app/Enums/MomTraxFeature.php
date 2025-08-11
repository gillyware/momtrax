<?php

declare(strict_types=1);

namespace App\Enums;

use App\Support\EnumHelpers;

enum MomTraxFeature: string
{
    use EnumHelpers;

    case PumpingEnabled = 'pumping_tracking';
    case PumpingPreferStartTime = 'pumping_tracking.prefer_start_time';
    case PumpingCountFromStart = 'pumping_tracking.count_from_start';
    case ChildrenEnabled = 'children_tracking';
}
