<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Master Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Master\DashboardController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\LineController;
use App\Http\Controllers\Master\MachineController;

/*
|--------------------------------------------------------------------------
| Default Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Master Routes
|--------------------------------------------------------------------------
*/
Route::prefix('master')
    ->name('master.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Master Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Master Data Resources
        |--------------------------------------------------------------------------
        */
        Route::resource('departments', DepartmentController::class)
            ->except(['show', 'destroy']);

        Route::resource('lines', LineController::class)
            ->except(['show', 'destroy']);

        Route::resource('machines', MachineController::class)
            ->except(['show', 'destroy']);
    });
