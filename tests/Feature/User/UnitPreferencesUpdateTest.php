<?php

declare(strict_types=1);

use App\Enums\HeightUnit;
use App\Enums\MilkUnit;
use App\Enums\WeightUnit;
use App\Models\User;

test('unit preferences page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('settings.units.edit'));

    $response->assertOk();
});

test('unit preferences can be updated', function () {
    $user = User::factory()->create();

    [$newMilkUnit, $newHeightUnit, $newWeightUnit] = [MilkUnit::random(), HeightUnit::random(), WeightUnit::random()];

    $response = $this
        ->actingAs($user)
        ->patch(route('settings.units.update'), [
            'milk_unit' => $newMilkUnit->value,
            'height_unit' => $newHeightUnit->value,
            'weight_unit' => $newWeightUnit->value,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('settings.units.edit'));

    $settings = $user->settings->refresh();

    expect($settings->milk_unit)->toBe($newMilkUnit)
        ->and($settings->height_unit)->toBe($newHeightUnit)
        ->and($settings->weight_unit)->toBe($newWeightUnit);
});
