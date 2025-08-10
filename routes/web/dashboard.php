<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/**
 * **********************************************************************************
 * Dashboard
 * **********************************************************************************
 */
Route::middleware('auth')->group(function () {

    Route::get('dashboard', fn () => Inertia::render('dashboard'))
        ->name('dashboard');

});
