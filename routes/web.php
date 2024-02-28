<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\OrdersController;

Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'login'])->name('login.enter');
Route::get('/logout', [LoginController::class,'logout'])->name('logout');

Route::get('/', [ItemsController::class,'index'])->name('items.index')->middleware('auth');

Route::get('/cart', [CartsController::class,'index'])->name('cart.index')->middleware('auth');
Route::post('/cart', [CartsController::class,'store'])->name('cart.store')->middleware('auth');
Route::delete('/cart', [CartsController::class,'destroy_by_current_user'])
                    ->name('cart.destroy_by_current_user')
                    ->middleware('auth');

Route::get('/orders', [OrdersController::class,'index'])->name('orders.index')->middleware('auth');
Route::post('/orders', [OrdersController::class,'store'])->name('orders.store')->middleware('auth');
Route::delete('/orders/{id}', [OrdersController::class,'destroy'])->name('orders.destroy')->middleware('auth');

