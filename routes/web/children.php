<?php

declare(strict_types=1);

use App\Http\Controllers\Child\ChildController;
use App\Http\Controllers\Child\FeedingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->name('children.')->group(function () {

    /**
     * **********************************************************************************
     * Registration
     * **********************************************************************************
     */
    Route::controller(ChildController::class)->group(function () {

        Route::get('/children', 'index')->name('index');

        Route::get('/children/new', 'create')->name('create');

        Route::post('/children', 'store')->name('store');

    });

    Route::middleware([])->group(function () {

        /**
         * **********************************************************************************
         * Settings
         * **********************************************************************************
         */
        Route::name('settings.')->group(function () {

            /**
             * **********************************************************************************
             * Profile
             * **********************************************************************************
             */
            Route::controller(ChildController::class)->name('profile.')->group(function () {

                Route::get('/children/{child}/settings/profile', 'edit')->name('edit');

                Route::put('/children/{child}/settings/profile', 'update')->name('update');

                Route::delete('/children/{child}/settings/profile', 'destroy')->name('destroy');

            });

        });

        /**
         * **********************************************************************************
         * Feedings
         * **********************************************************************************
         */
        Route::controller(FeedingController::class)->name('feedings.')->group(function () {

            Route::get('/children/{child}/feedings', 'index')->name('index');

            Route::get('/children/{child}/feedings/new', 'create')->name('create');

            Route::post('/children/{child}/feedings', 'store')->name('store');

            Route::get('/children/{child}/feedings/{feeding}', 'edit')->name('edit');

            Route::put('/children/{child}/feedings/{feeding}', 'update')->name('update');

            Route::delete('/children/{child}/feedings/{feeding}', 'destroy')->name('destroy');

        });

    });

});
