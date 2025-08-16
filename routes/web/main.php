<?php

declare(strict_types=1);

use App\Http\Controllers\Main\DashboardController;
use App\Http\Controllers\Main\StaticController;
use Illuminate\Support\Facades\Route;

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
Route::get('/dashboard', DashboardController::class)
    ->middleware('auth')
    ->name('dashboard');
