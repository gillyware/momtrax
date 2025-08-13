<?php

declare(strict_types=1);

use App\Enums\MomTraxUserFeature;
use App\Models\User;

// test('features page is displayed', function () {
//     $user = User::factory()->create();

//     $response = $this
//         ->actingAs($user)
//         ->get('/settings/features');

//     $response->assertOk();
// });

test('features can be toggled', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/settings/features')
        ->patch('/settings/features', [
            'feature_name' => $featureName = MomTraxUserFeature::random()->value,
            'enabled' => $enabled = fake()->boolean(),
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/settings/features');

    $user = $user->refresh();

    expect($user->hasFeature($featureName))->toBe($enabled);
});
