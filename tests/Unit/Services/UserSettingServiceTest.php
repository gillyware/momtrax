<?php

declare(strict_types=1);

use App\Enums\HeightUnit;
use App\Enums\MilkUnit;
use App\Enums\WeightUnit;
use App\Models\User;
use App\Packets\UserSettings\UpdateLocalizationPacket;
use App\Packets\UserSettings\UpdateUnitPreferencesPacket;
use App\Services\UserSettingService;

beforeEach(function () {
    $this->userSettingService = resolve(UserSettingService::class);
});

test('updateUnitPreferences() updates user unit preferences', function () {
    $user = User::factory()->create();

    [$newMilkUnit, $newHeightUnit, $newWeightUnit] = [MilkUnit::random(), HeightUnit::random(), WeightUnit::random()];

    $packet = UpdateUnitPreferencesPacket::from([
        'milk_unit' => $newMilkUnit->value,
        'height_unit' => $newHeightUnit->value,
        'weight_unit' => $newWeightUnit->value,
    ]);

    $settings = $this->userSettingService->update($user->settings, $packet);

    expect($settings->milk_unit)->toBe($newMilkUnit)
        ->and($settings->height_unit)->toBe($newHeightUnit)
        ->and($settings->weight_unit)->toBe($newWeightUnit);
});

test('update() updates user localization', function () {
    $user = User::factory()->create();

    $timezone = 'America/New_York';

    $packet = UpdateLocalizationPacket::from([
        'timezone' => $timezone,
    ]);

    $settings = $this->userSettingService->update($user->settings, $packet);

    expect($settings->timezone)->toBe($timezone);
});
