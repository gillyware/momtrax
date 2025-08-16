<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    /**
     * **********************************************************************************
     * Login
     * **********************************************************************************
     */
    Route::controller(AuthenticatedSessionController::class)->group(function () {

        Route::get('/login', 'create')->name('login');

        Route::post('/login', 'store');

    });

    /**
     * **********************************************************************************
     * Forgot Password
     * **********************************************************************************
     */
    Route::controller(PasswordResetLinkController::class)->name('password.')->group(function () {

        Route::get('/forgot-password', 'create')->name('request');

        Route::post('/forgot-password', 'store')->name('email');

    });

    /**
     * **********************************************************************************
     * Reset Password
     * **********************************************************************************
     */
    Route::controller(NewPasswordController::class)->name('password.')->group(function () {

        Route::get('/reset-password/{token}', 'create')->name('reset');

        Route::post('/reset-password', 'store')->name('store');

    });

});

Route::middleware('auth')->group(function () {

    /**
     * **********************************************************************************
     * Confirm Password
     * **********************************************************************************
     */
    Route::controller(ConfirmablePasswordController::class)->group(function () {

        Route::get('/confirm-password', 'show')->name('password.confirm');

        Route::post('/confirm-password', 'store');

    });

    /**
     * **********************************************************************************
     * Logout
     * **********************************************************************************
     */
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

});
