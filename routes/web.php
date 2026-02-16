<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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
use App\Http\Controllers\Master\MdHeatNumberController;
use App\Http\Controllers\Master\AuditLogController;
use App\Http\Controllers\Master\ItemImportController;
use App\Http\Controllers\Master\TrendAnalyticsController;
use App\Http\Controllers\Master\MasterCategoryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'app_access'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return redirect()->route('master.dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | MASTER DATA
    |--------------------------------------------------------------------------
    */
    Route::prefix('master')->as('master.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Master Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('trend-analytics', [TrendAnalyticsController::class, 'index'])
            ->name('trend-analytics');

        Route::post('trend-analytics/report', [TrendAnalyticsController::class, 'generateReport'])
            ->name('trend-analytics.report');

        /*
        |--------------------------------------------------------------------------
        | Departments
        |--------------------------------------------------------------------------
        */
        Route::patch('departments/{department}/deactivate', [DepartmentController::class, 'deactivate'])
            ->name('departments.deactivate');

        Route::patch('departments/{department}/activate', [DepartmentController::class, 'activate'])
            ->name('departments.activate');

        Route::resource('departments', DepartmentController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Lines
        |--------------------------------------------------------------------------
        */
        Route::patch('lines/{line}/deactivate', [LineController::class, 'deactivate'])
            ->name('lines.deactivate');

        Route::patch('lines/{line}/activate', [LineController::class, 'activate'])
            ->name('lines.activate');

        Route::resource('lines', LineController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Machines
        |--------------------------------------------------------------------------
        */
        Route::patch('machines/{machine}/deactivate', [MachineController::class, 'deactivate'])
            ->name('machines.deactivate');

        Route::patch('machines/{machine}/activate', [MachineController::class, 'activate'])
            ->name('machines.activate');

        Route::resource('machines', MachineController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Items (CUSTOM ROUTE HARUS DI ATAS RESOURCE)
        |--------------------------------------------------------------------------
        */
        Route::get('items/select', [MasterCategoryController::class, 'selectItems'])
            ->name('items.select');

        Route::get('/items/import', [ItemImportController::class, 'form'])->name('items.import.form');
        Route::post('/items/import', [ItemImportController::class, 'import'])->name('items.import');
        Route::post('/items/bulk-store', [ItemImportController::class, 'bulkStore'])->name('items.bulk-store');

        Route::patch('items/{item}/deactivate', [ItemController::class, 'deactivate'])
            ->name('items.deactivate');

        Route::patch('items/{item}/activate', [ItemController::class, 'activate'])
            ->name('items.activate');

        Route::resource('items', ItemController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Operators (DESAIN BERBEDA — JANGAN DIUBAH)
        |--------------------------------------------------------------------------
        */

        // ✅ ROUTE BARU (WAJIB) — DEACTIVATE DENGAN KONFIRMASI
        Route::patch(
            'operators/{operator}/deactivate-confirm',
            [OperatorController::class, 'confirmDeactivate']
        )->name('operators.deactivate.confirm');

        // Legacy activate / deactivate (tetap dipertahankan)
        Route::post('operators/{id}/deactivate', [OperatorController::class, 'deactivate'])
            ->name('operators.deactivate');

        Route::post('operators/{id}/activate', [OperatorController::class, 'activate'])
            ->name('operators.activate');

        Route::resource('operators', OperatorController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Heat Numbers
        |--------------------------------------------------------------------------
        */
        Route::get('heat-numbers/select', [MasterCategoryController::class, 'selectHeatNumbers'])
            ->name('heat-numbers.select');

        Route::controller(MdHeatNumberController::class)->prefix('heat-numbers')->name('heat-numbers.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/date/{date}', 'dailyDetails')->name('daily-details');
            Route::get('/import', 'import')->name('import');
            Route::post('/bulk-store', 'bulkStore')->name('bulk-store');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{heatNumber}/edit', 'edit')->name('edit');
            Route::put('/{heatNumber}', 'update')->name('update');
            Route::patch('/{heatNumber}/deactivate', 'deactivate')->name('deactivate');
            Route::patch('/{heatNumber}/activate', 'activate')->name('activate');
        });

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        | Only accessible by Dept 100/100.1 (Check inside Controller)
        */
        Route::resource('users', \App\Http\Controllers\Master\UserController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Audit Logs
        |--------------------------------------------------------------------------
        */
        Route::get('audit-logs', [AuditLogController::class, 'index'])
            ->name('audit-logs.index');
    });
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
