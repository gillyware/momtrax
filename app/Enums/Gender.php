<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumHelpers;

enum Gender: string
{
    use EnumHelpers;

    case Male = 'male';
    case Female = 'female';
}
