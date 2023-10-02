<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

Route::controller(ApplicationController::class)
        ->prefix('applications')
        ->as('applications.')
        ->middleware('auth')
        ->group(function () {

    Route::get('all', 'all')->name('all');
    Route::get('index', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/{application}', 'show')->name('show');
    Route::patch('update/{application}', 'update')->name('update');

});