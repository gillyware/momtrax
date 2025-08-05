<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\StaticController;

Route::controller(StaticController::class)->group(function () {

    Route::get('/', 'welcome')->name('home');

    Route::get('/terms', 'termsOfService')->name('terms');

    Route::get('/privacy', 'privacyPolicy')->name('privacy');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
