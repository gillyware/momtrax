<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Appearance;
use App\Enums\HeightUnit;
use App\Enums\MilkUnit;
use App\Enums\WeightUnit;
use App\Models\UserSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserSetting>
 */
final class UserSettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(),
            'milk_unit' => MilkUnit::random(),
            'height_unit' => HeightUnit::random(),
            'weight_unit' => WeightUnit::random(),
            'appearance' => Appearance::random(),
        ];
    }
}
