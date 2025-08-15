<?php

declare(strict_types=1);

use App\Http\Controllers\User\RegisteredUserController;
use App\Http\Controllers\User\Settings\FeaturesController;
use App\Http\Controllers\User\Settings\LocalizationController;
use App\Http\Controllers\User\Settings\PasswordController;
use App\Http\Controllers\User\Settings\ProfileController;
use App\Http\Controllers\User\Settings\UnitPreferencesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {

    /**
     * **********************************************************************************
     * Registration
     * **********************************************************************************
     */
    Route::controller(RegisteredUserController::class)->group(function () {

        Route::get('/register', 'create')->name('register');

        Route::post('/register', 'store')->middleware('throttle:6,1');

    });

});

Route::middleware('auth')->group(function () {

    /**
     * **********************************************************************************
     * Profile
     * **********************************************************************************
     */
    Route::redirect('/settings', '/settings/profile');

    Route::controller(ProfileController::class)->group(function () {

        Route::get('/settings/profile', 'edit')->name('profile.edit');

        Route::patch('/settings/profile', 'update')->name('profile.update');

        Route::delete('/settings/profile', 'destroy')->name('profile.destroy');

    });

    /**
     * **********************************************************************************
     * Features
     * **********************************************************************************
     */
    Route::controller(FeaturesController::class)->group(function () {

        Route::get('/settings/features', 'edit')->name('features.edit');

        Route::patch('/settings/features', 'update')->name('features.update');

    });

    /**
     * **********************************************************************************
     * Unit Preferences
     * **********************************************************************************
     */
    Route::controller(UnitPreferencesController::class)->group(function () {

        Route::get('/settings/units', 'edit')->name('units.edit');

        Route::patch('/settings/units', 'update')->name('units.update');

    });

    /**
     * **********************************************************************************
     * Localization
     * **********************************************************************************
     */
    Route::controller(LocalizationController::class)->group(function () {

        Route::get('/settings/localization', 'edit')->name('localization.edit');

        Route::patch('/settings/localization', 'update')->name('localization.update');

    });

    /**
     * **********************************************************************************
     * Appearance
     * **********************************************************************************
     */
    Route::get('/settings/appearance', fn () => Inertia::render('settings/appearance'))
        ->name('appearance');

    /**
     * **********************************************************************************
     * Password
     * **********************************************************************************
     */
    Route::controller(PasswordController::class)->group(function () {

        Route::get('/settings/password', 'edit')->name('password.edit');

        Route::put('/settings/password', 'update')->name('password.update');

    });

});
