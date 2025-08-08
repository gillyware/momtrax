<?php

declare(strict_types=1);

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'nickname' => 'Tester',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'timezone' => 'America/New_York',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
