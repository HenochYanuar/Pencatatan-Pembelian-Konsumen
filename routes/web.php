<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// product endpoint
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/add', [ProductController::class, 'add'])->name('products.add');
Route::post('/products', [ProductController::class, 'addPost'])->name('products.addPost');
Route::get('/products/edit/{productId}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products', [ProductController::class, 'editPost'])->name('products.editPost');
Route::delete('/products/{productId}', [ProductController::class, 'delete'])->name('products.delete');


// order endpoint
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/order/data', [OrderController::class, 'orderData'])->name('order.orderData');
Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

