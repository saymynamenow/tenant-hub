<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserCentral;

Route::post('/tenants/register', [TenantController::class, 'register']);
Route::post('/tenant-requests', [TenantRequestController::class, 'store']);
Route::post('/central/login', [UserCentral::class, 'loginCentralUser']);
Route::post('/central/logout', [UserCentral::class, 'logoutCentralUser']);
Route::get('/central/me', [UserCentral::class, 'meCentralUser']);
Route::post('/central/register', [UserCentral::class, 'registerCentralUser']);

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/getTenant', [TenantController::class, 'index']);
    Route::get('/tenants/stats', [TenantController::class, 'stats']);
    Route::post('/tenants', [TenantController::class, 'store']);
    Route::patch('/tenants/{id}/status', [TenantController::class, 'UpdateTenantStatus']);
    Route::delete('/tenants/{id}', [TenantController::class, 'destroy']);
    
    // Tenant request management (admin only)
    Route::get('/tenant-requests', [TenantRequestController::class, 'index']);
    Route::post('/tenant-requests/{id}/approve', [TenantRequestController::class, 'approve']);
    Route::patch('/tenant-requests/{id}/status', [TenantRequestController::class, 'updateStatus']);
    Route::delete('/tenant-requests/{id}', [TenantRequestController::class, 'destroy']);
});

Route::middleware(['web', 'identify.tenant'])->group(function () {
    Route::get('/tenant/status', [TenantController::class, 'status']);
       Route::post('/tenant/register', [UserController::class, 'register']);
    Route::post('/tenant/login', [UserController::class, 'login']);
    Route::get('/tenant/me', [UserController::class, 'me']);
    Route::post('/tenant/logout', [UserController::class, 'logout']);

    Route::get('/products', [ProductsController::class, 'index']);
    Route::post('/products', [ProductsController::class, 'store']);
    Route::get('/products/{id}', [ProductsController::class, 'show']);
    Route::put('/products/{id}', [ProductsController::class, 'update']);
    Route::delete('/products/{id}', [ProductsController::class, 'destroy']);

    Route::post('/cart/add-to-cart', [CartController::class, 'addToCart']);
    Route::get('/cart/view-cart', [CartController::class, 'viewCart']);
    Route::delete('/cart/clear-cart', [CartController::class, 'clearCart']);
    Route::delete('/cart/remove-item/{itemId}', [CartController::class, 'removeItem']);
    Route::put('/cart/update-item/{itemId}', [CartController::class, 'updateItem']);

    Route::post('/orders/checkout', [OrderController::class, 'checkout']);
    Route::get('/orders', [OrderController::class, 'getOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'getOrderDetails']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateOrderStatus']);
    Route::delete('/getallorders', [OrderController::class, 'getAdminOrders']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*')->middleware('check.tenant.status');
