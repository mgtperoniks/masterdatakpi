<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\LineController;
use App\Http\Controllers\Master\MachineController;

/*
|--------------------------------------------------------------------------
| Web Routes
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

        Route::resource('departments', DepartmentController::class)
            ->except(['show', 'destroy']);

        Route::resource('lines', LineController::class)
            ->except(['show', 'destroy']);

        Route::resource('machines', MachineController::class)
            ->except(['show', 'destroy']);

        
    });
