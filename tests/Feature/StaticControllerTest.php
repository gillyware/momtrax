<?php

declare(strict_types=1);

test('users can visit the home page', function () {
    $this->get(route('home'))->assertStatus(200);
});

test('users can visit the privacy policy', function () {
    $this->get(route('privacy'))->assertStatus(200);
});

test('users can visit the terms of service', function () {
    $this->get(route('terms'))->assertStatus(200);
});
