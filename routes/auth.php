<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    /**
     * **********************************************************************************
     * Registration
     * **********************************************************************************
     */

    Route::controller(RegisteredUserController::class)->group(function () {

        Route::get('/register', 'create')->name('register');

        Route::post('/register', 'store');

    });

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

    Route::controller(PasswordResetLinkController::class)->group(function () {

        Route::get('/forgot-password', 'create')->name('password.request');

        Route::post('/forgot-password', 'store')->name('password.email');

    });

    /**
     * **********************************************************************************
     * Reset Password
     * **********************************************************************************
     */

    Route::controller(NewPasswordController::class)->group(function () {

        Route::get('/reset-password/{token}', 'create')->name('password.reset');

        Route::post('/reset-password', 'store')->name('password.store');

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
