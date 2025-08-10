<?php

declare(strict_types=1);

use App\Enums\Appearance;
use App\Enums\HeightUnit;
use App\Enums\MilkUnit;
use App\Enums\WeightUnit;
use App\Models\User;
use App\Models\UserSetting;
use App\Packets\UserSettings\UpdateUnitPreferencesPacket;
use App\Repositories\UserSettingRepository;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelExists;

beforeEach(function () {
    $this->userSettingRepository = resolve(UserSettingRepository::class);
});

test('create() persists user settings', function () {
    $user = User::factory()->withoutSettings()->create();

    $settings = $this->userSettingRepository->createForUser($user);

    assertModelExists($settings);

    assertDatabaseHas((new UserSetting)->getTable(), [
        'user_id' => $user->id,
    ]);

    expect($settings->milk_unit)->toBeIn(MilkUnit::all())
        ->and($settings->height_unit)->toBeIn(HeightUnit::all())
        ->and($settings->weight_unit)->toBeIn(WeightUnit::all())
        ->and($settings->appearance)->toBeIn(Appearance::all());
});

test('updateUnitPreferences() updates user unit preferences', function () {
    $user = User::factory()->create();

    [$newMilkUnit, $newHeightUnit, $newWeightUnit] = [MilkUnit::random(), HeightUnit::random(), WeightUnit::random()];

    $packet = UpdateUnitPreferencesPacket::from([
        'milk_unit' => $newMilkUnit->value,
        'height_unit' => $newHeightUnit->value,
        'weight_unit' => $newWeightUnit->value,
    ]);

    $settings = $this->userSettingRepository->updateUnitPreferences($user->settings, $packet);

    expect($settings->milk_unit)->toBe($newMilkUnit)
        ->and($settings->height_unit)->toBe($newHeightUnit)
        ->and($settings->weight_unit)->toBe($newWeightUnit);
});
