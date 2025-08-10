<?php

declare(strict_types=1);

namespace App\Support;

trait EnumHelpers
{
    public static function all(): array
    {
        return self::cases();
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function random(): self
    {
        return self::cases()[array_rand(self::cases())];
    }
}
