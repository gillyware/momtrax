<?php

declare(strict_types=1);

use App\Http\Controllers\Child\ChildController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    /**
     * **********************************************************************************
     * Children
     * **********************************************************************************
     */
    Route::controller(ChildController::class)->name('children.')->group(function () {

        Route::get('/children', 'index')->name('index');

        Route::get('/children/new', 'create')->name('create');

        Route::post('/children', 'store')->name('store');

        Route::get('/children/{child}', 'edit')->name('edit');

        // Route::put('/children/{child}', 'update')->name('update');

        // Route::delete('/children/{child}', 'destroy')->name('destroy');

    });

});
