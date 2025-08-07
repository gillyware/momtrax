<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\StaticController;

/**
 * **********************************************************************************
 * Static Content
 * **********************************************************************************
 */

Route::controller(StaticController::class)->group(function () {

    Route::get('/', 'welcome')->name('home');

    Route::get('/terms', 'termsOfService')->name('terms');

    Route::get('/privacy', 'privacyPolicy')->name('privacy');

});

/**
 * **********************************************************************************
 * Dashboard
 * **********************************************************************************
 */

Route::middleware('auth')->group(function () {

    Route::get('dashboard', fn () => Inertia::render('dashboard'))
        ->name('dashboard');

});

/**
 * **********************************************************************************
 * Settings
 * **********************************************************************************
 */

require __DIR__.'/settings.php';

/**
 * **********************************************************************************
 * Auth
 * **********************************************************************************
 */

require __DIR__.'/auth.php';
