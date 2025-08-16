<?php

declare(strict_types=1);

use App\Enums\MomTraxUserFeature;
use App\Models\User;

// test('features page is displayed', function () {
//     $user = User::factory()->create();

//     $response = $this
//         ->actingAs($user)
//         ->get(route('settings.features.edit'));

//     $response->assertOk();
// });

test('features can be toggled', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from(route('settings.features.edit'))
        ->patch(route('settings.features.update'), [
            'feature_name' => $featureName = MomTraxUserFeature::random()->value,
            'enabled' => $enabled = fake()->boolean(),
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('settings.features.edit'));

    $user = $user->refresh();

    expect($user->hasFeature($featureName))->toBe($enabled);
});
