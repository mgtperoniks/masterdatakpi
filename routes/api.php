<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sync\ModuleSyncController;

Route::post('sync/machines', [ModuleSyncController::class, 'syncMachines']);
