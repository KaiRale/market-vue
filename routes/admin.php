<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParamController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductParentController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->prefix('admin')
    ->middleware(['auth', IsAdminMiddleware::class]);


// IsAdminMiddleware - пользовательский посредник (middleware), который проверяет,
// является ли текущий аутентифицированный пользователь администратором
Route::prefix('admin')->name('admin.')->middleware(['auth', IsAdminMiddleware::class])->group( function () {
    Route::resource('products', ProductController::class);
    Route::resource('params', ParamController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('product-parents', ProductParentController::class)->parameters(['product-parents' => 'productParents']);
});
