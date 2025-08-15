<?php

declare(strict_types=1);

use App\Models\User;
use Gillyware\Atlas\Facades\Atlas;

test('localization page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/settings/localization');

    $response->assertOk();
});

test('localization can be updated', function () {
    $user = User::factory()->create();

    $timezone = Atlas::timezones()->all()->keys()->random();

    $response = $this
        ->actingAs($user)
        ->patch('/settings/localization', [
            'timezone' => $timezone,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/settings/localization');

    $settings = $user->settings->refresh();

    expect($settings->timezone)->toBe($timezone);
});
