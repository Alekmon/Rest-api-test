<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
        ->prefix('auth')
        ->as('auth.')
        ->middleware('api')
        ->group(function () {
    
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me');

        });

Route::controller(ApplicationController::class)
        ->prefix('applications')
        ->as('applications.')
        ->middleware('auth')
        ->group(function () {

    Route::get('all', 'all')->name('all');
    Route::post('/', 'store')->name('store');
    Route::get('/{application}', 'show')->name('show');

});
