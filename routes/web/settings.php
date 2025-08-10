<?php

declare(strict_types=1);

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\UnitPreferencesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
     * Unit Preferences
     * **********************************************************************************
     */
    Route::controller(UnitPreferencesController::class)->group(function () {

        Route::get('/settings/units', 'edit')->name('units.edit');

        Route::patch('/settings/units', 'update')->name('units.update');

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
