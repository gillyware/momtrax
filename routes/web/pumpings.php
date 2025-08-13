<?php

declare(strict_types=1);

use App\Http\Controllers\Pumping\PumpingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    /**
     * **********************************************************************************
     * Pumpings
     * **********************************************************************************
     */
    Route::controller(PumpingController::class)->name('pumpings.')->group(function () {

        Route::get('/pumpings', 'index')->name('index');

        Route::get('/pumpings/new', 'create')->name('create');

        Route::post('/pumpings', 'store')->name('store');

        Route::get('/pumpings/{pumping}', 'edit')->name('edit');

        Route::put('/pumpings/{pumping}', 'update')->name('update');

        Route::delete('/pumpings/{pumping}', 'destroy')->name('destroy');

    });

});
