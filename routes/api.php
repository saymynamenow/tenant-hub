<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;

// Central Admin Routes - Tenant Management
Route::prefix('central')->group(function () {
    Route::get('/tenants', [TenantController::class, 'index']);
    Route::get('/tenants/stats', [TenantController::class, 'stats']);
    Route::post('/tenants', [TenantController::class, 'store']);
    Route::patch('/tenants/{id}/status', [TenantController::class, 'updateStatus']);
    Route::delete('/tenants/{id}', [TenantController::class, 'destroy']);
});
