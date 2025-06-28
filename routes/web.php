<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

// untuk products
Route::resource('products', ProductController::class);

// untuk categories
Route::resource('categories', CategoryController::class);

// untuk sale
Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
Route::post('/sales/scan', [SaleController::class, 'scanBarcode'])->name('sales.scan');
Route::delete('/sales/item/{id}', [SaleController::class, 'destroyItem'])->name('sales.item.destroy');
Route::post('/sales/store', [SaleController::class, 'store'])->name('sales.store');
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth routes (tanpa register)
Auth::routes(['register' => false]);

// Route setelah login
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
});

// route untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/', fn () => redirect('/dashboard'));

// middleware untuk user
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
});

// route untuk struk
Route::get('/sales/receipt/{id}', [SaleController::class, 'receipt'])->name('sales.receipt')->middleware('auth');

// route untuk laporan
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
});

// route untuk cetak laporan(pdf) penjualan
Route::get('/laporan/cetak', [ReportController::class, 'exportPdf'])->name('report.pdf')->middleware('auth', 'is_admin');