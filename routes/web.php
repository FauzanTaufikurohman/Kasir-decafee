<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['role:1'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/report', [ReportController::class, 'index'])->name('report');

    // Menu Routes FOR Manajemen
    Route::post('/menu-create', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Category Menu Routes FOR Manajemen
    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::post('/category-create', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'show'])->name('category.show');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // USER ROUTES
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/user-create', [UserController::class, 'store'])->name('users.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});
Route::middleware(['role:1,2,3,4'])->group(function () {

    Route::get('/menu', [MenuController::class, 'index'])->name('menu');

    Route::get('/order', [OrderController::class, 'index'])->name('order');

    // PROFILE ROUTES
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

});
