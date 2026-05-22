<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailSalesController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/beranda', [DashboardController::class, 'index']);

// Route::get('/produk', function () {
//     return view('produk');
// });

// Route::get('/penjualan', function () {
//     return view('penjualan');
// });

Route::post('/api/login', [UserController::class, 'login'])->name('api.login');
Route::post('/api/logout', [UserController::class, 'logout'])->name('api.logout');

// Product
Route::get('/produk', [ProductController::class, 'index'])->name('product.index');
Route::post('/api/product/store', [ProductController::class, 'store'])->name('api.product.store');
Route::post('/api/product/update', [ProductController::class, 'update'])->name('api.product.update');
Route::post('/api/product/delete', [ProductController::class, 'delete'])->name('api.product.delete');

// Customer
Route::get('/pelanggan', [CustomerController::class, 'index']);
Route::post('/api/customer/store', [CustomerController::class, 'store'])->name('api.customer.store');
Route::post('/api/customer/update', [CustomerController::class, 'update'])->name('api.customer.update');
Route::post('/api/customer/delete', [CustomerController::class, 'delete'])->name('api.customer.delete');

// Sales
Route::get('/penjualan', [SalesController::class, 'index']);
Route::get('/penjualan/detail/{id}', [SalesController::class, 'detail'])->name('api.sales.detail');
Route::post('api/sales/store', [SalesController::class, 'store'])->name('api.sales.store');
Route::post('api/sales/delete', [SalesController::class, 'delete'])->name('api.sales.delete');

// Detail Sales
Route::post('api/detailsales/store', [DetailSalesController::class, 'store'])->name('api.detailsales.store');
Route::post('api/detailsales/update/item', [DetailSalesController::class, 'update_item'])->name('api.detailsales.update.item');
Route::post('api/detailsales/update/qty', [DetailSalesController::class, 'update_qty'])->name('api.detailsales.update.qty');
Route::post('api/detailsales/delete', [DetailSalesController::class, 'delete'])->name('api.detailsales.delete');

// Income
Route::get('/pendapatan', [IncomeController::class, 'index']);