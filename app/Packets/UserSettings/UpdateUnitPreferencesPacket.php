<?php

declare(strict_types=1);

namespace App\Packets\UserSettings;

use App\Enums\HeightUnit;
use App\Enums\MilkUnit;
use App\Enums\WeightUnit;
use Gillyware\Postal\Attributes\Field;
use Gillyware\Postal\Attributes\Rule;
use Illuminate\Validation\Rule as ValidationRule;

final class UpdateUnitPreferencesPacket extends UpdateUserSettingPacket
{
    public readonly MilkUnit $milkUnit;

    public readonly HeightUnit $heightUnit;

    public readonly WeightUnit $weightUnit;

    public function __construct(
        #[Field('milk_unit'), Rule(['required', 'string'])]
        string $milkUnit,
        #[Field('height_unit'), Rule(['required', 'string'])]
        string $heightUnit,
        #[Field('weight_unit'), Rule(['required', 'string'])]
        string $weightUnit,
    ) {
        $this->milkUnit = MilkUnit::from($milkUnit);
        $this->heightUnit = HeightUnit::from($heightUnit);
        $this->weightUnit = WeightUnit::from($weightUnit);
    }

    public function toArray(): array
    {
        return [
            'milk_unit' => $this->milkUnit,
            'height_unit' => $this->heightUnit,
            'weight_unit' => $this->weightUnit,
        ];
    }

    protected static function explicitRules(): array
    {
        return [
            'milk_unit' => [ValidationRule::in(MilkUnit::values())],
            'height_unit' => [ValidationRule::in(HeightUnit::values())],
            'weight_unit' => [ValidationRule::in(WeightUnit::values())],
        ];
    }
}
