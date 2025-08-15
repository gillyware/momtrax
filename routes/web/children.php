<?php

declare(strict_types=1);

use App\Http\Controllers\Child\ChildController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    /**
     * **********************************************************************************
     * Register
     * **********************************************************************************
     */
    Route::controller(ChildController::class)->name('children.')->group(function () {

        Route::get('/children', 'index')->name('index');

        Route::get('/children/new', 'create')->name('create');

        Route::post('/children', 'store')->name('store');

        Route::get('/children/{child:uuid}', 'edit')->name('edit');

        Route::put('/children/{child:uuid}', 'update')->name('update');

        Route::delete('/children/{child:uuid}', 'destroy')->name('destroy');

    });

});
