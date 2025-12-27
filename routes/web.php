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
use App\Http\Controllers\Master\ItemController;
use App\Http\Controllers\Master\OperatorController;
use App\Http\Controllers\Master\AuditLogController;
use App\Http\Controllers\Master\ItemImportController;

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
    ->as('master.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Master Data
        |--------------------------------------------------------------------------
        */
        Route::resource('departments', DepartmentController::class)
            ->except(['show', 'destroy']);

        Route::resource('lines', LineController::class)
            ->except(['show', 'destroy']);

        Route::resource('machines', MachineController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Items (FULL CRUD TANPA SHOW & DESTROY)
        |--------------------------------------------------------------------------
        */
        Route::resource('items', ItemController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Item Import
        |--------------------------------------------------------------------------
        */
        Route::get('items/import', [ItemImportController::class, 'form'])
            ->name('items.import.form');

        Route::post('items/import', [ItemImportController::class, 'import'])
            ->name('items.import');

        /*
        |--------------------------------------------------------------------------
        | Operators
        |--------------------------------------------------------------------------
        */
        Route::resource('operators', OperatorController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Audit & Monitoring
        |--------------------------------------------------------------------------
        */
        Route::resource('audit-logs', AuditLogController::class)
            ->only(['index']);
    });
