<?php

declare(strict_types=1);

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('home screen can be rendered', function () {
    $this->get(route('home'))->assertStatus(200);
});

test('terms of service can be rendered', function () {
    $this->get(route('terms'))->assertStatus(200);
});

test('privacy policy can be rendered', function () {
    $this->get(route('privacy'))->assertStatus(200);
});
