<?php

use App\Http\Controllers\Acara17Controller;
use App\Http\Controllers\Acara18Controller;
use App\Http\Controllers\Acara19Controller;
use App\Http\Controllers\Acara20Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
    Route::get('/register', [AuthController::class, 'createRegistration'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::get('/dashboard', fn () => to_route('admin.dashboard'))
    ->middleware('auth')
    ->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('produk', ProductController::class)
        ->except(['show'])
        ->parameters(['produk' => 'product']);
    Route::view('/kategori', 'admin')->name('kategori');
});

Route::middleware('auth')->get('/kasir/transaksi', fn () => 'Halaman Input Transaksi Penjualan (Kasir)')
    ->name('kasir.transaksi');

Route::get('/produk/cari/{nama?}', fn (?string $nama = null) => $nama
    ? 'Hasil pencarian produk: '.$nama
    : 'Silakan masukkan kata kunci pencarian.');
Route::get('/produk/{id}', fn (int $id) => 'Menampilkan data produk dengan ID: '.$id);

Route::get('/test-query', [Acara17Controller::class, 'index']);
Route::get('/test-eloquent', [Acara18Controller::class, 'index']);
Route::get('/test-crud', [Acara19Controller::class, 'index']);
Route::get('/test-relasi', [Acara20Controller::class, 'index']);
