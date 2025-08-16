<?php

declare(strict_types=1);

use App\Http\Controllers\User\FeaturesController;
use App\Http\Controllers\User\LocalizationController;
use App\Http\Controllers\User\PasswordController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PumpingController;
use App\Http\Controllers\User\RegisteredUserController;
use App\Http\Controllers\User\UnitPreferencesController;
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

/**
 * **********************************************************************************
 * Settings
 * **********************************************************************************
 */
Route::middleware('auth')->name('settings.')->group(function () {

    /**
     * **********************************************************************************
     * Profile
     * **********************************************************************************
     */
    Route::redirect('/settings', '/settings/profile');

    Route::controller(ProfileController::class)->name('profile.')->group(function () {

        Route::get('/settings/profile', 'edit')->name('edit');

        Route::patch('/settings/profile', 'update')->name('update');

        Route::delete('/settings/profile', 'destroy')->name('destroy');

    });

    /**
     * **********************************************************************************
     * Features
     * **********************************************************************************
     */
    Route::controller(FeaturesController::class)->name('features.')->group(function () {

        Route::get('/settings/features', 'edit')->name('edit');

        Route::patch('/settings/features', 'update')->name('update');

    });

    /**
     * **********************************************************************************
     * Unit Preferences
     * **********************************************************************************
     */
    Route::controller(UnitPreferencesController::class)->name('units.')->group(function () {

        Route::get('/settings/units', 'edit')->name('edit');

        Route::patch('/settings/units', 'update')->name('update');

    });

    /**
     * **********************************************************************************
     * Localization
     * **********************************************************************************
     */
    Route::controller(LocalizationController::class)->name('localization.')->group(function () {

        Route::get('/settings/localization', 'edit')->name('edit');

        Route::patch('/settings/localization', 'update')->name('update');

    });

    /**
     * **********************************************************************************
     * Appearance
     * **********************************************************************************
     */
    Route::get('/settings/appearance', fn () => Inertia::render('users/settings/appearance'))
        ->name('appearance');

    /**
     * **********************************************************************************
     * Password
     * **********************************************************************************
     */
    Route::controller(PasswordController::class)->name('password.')->group(function () {

        Route::get('/settings/password', 'edit')->name('edit');

        Route::put('/settings/password', 'update')->name('update');

    });

});

/**
 * **********************************************************************************
 * Pumpings
 * **********************************************************************************
 */
Route::controller(PumpingController::class)->middleware('auth')->name('pumpings.')->group(function () {

    Route::get('/pumpings', 'index')->name('index');

    Route::get('/pumpings/new', 'create')->name('create');

    Route::post('/pumpings', 'store')->name('store');

    Route::get('/pumpings/{pumping}', 'edit')->name('edit');

    Route::put('/pumpings/{pumping}', 'update')->name('update');

    Route::delete('/pumpings/{pumping}', 'destroy')->name('destroy');

});
