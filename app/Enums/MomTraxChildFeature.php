<?php

declare(strict_types=1);

namespace App\Enums;

use App\Support\EnumHelpers;

enum MomTraxChildFeature: string
{
    use EnumHelpers;

    /**
     * **********************************************************************************
     * Feeding
     * **********************************************************************************
     */
    case FeedingEnabled = 'child.feeding_tracking';
    case FeedingPreferStartTime = 'child.feeding_tracking.prefer_start_time';
    case FeedingCountFromStart = 'child.feeding_tracking.count_from_start';
    case FeedingDisplayDailyTotal = 'child.feeding_tracking.display_daily_total';
    case FeedingDisplayDailyTime = 'child.feeding_tracking.display_daily_time';
    case FeedingShowBreastFeeding = 'child.feeding_tracking.show_breast_feeding';
    case FeedingShowBottleFeeding = 'child.feeding_tracking.show_bottle_feeding';
    case FeedingShowFormulaFeeding = 'child.feeding_tracking.show_formula_feeding';

    /**
     * **********************************************************************************
     * Sleeping
     * **********************************************************************************
     */
    case SleepingEnabled = 'child.sleeping_tracking';
    case SleepingQuickAdd = 'child.sleeping_tracking.quick_add';

    /**
     * **********************************************************************************
     * Growth
     * **********************************************************************************
     */
    case GrowthEnabled = 'child.growth_tracking';
    case GrowthHeightTracking = 'child.growth_tracking.height_tracking';
    case GrowthWeightTracking = 'child.growth_tracking.weight_tracking';

    /**
     * **********************************************************************************
     * Diapers
     * **********************************************************************************
     */
    case DiaperEnabled = 'child.diaper_tracking';
}
