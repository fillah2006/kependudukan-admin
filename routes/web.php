<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KematianController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelahiranController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KependudukanController;

// Public routes
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Kependudukan route (jika tidak perlu login)
Route::get('/adminpenduduk', [KependudukanController::class, 'index'])->name('kependudukan.index');

// Protected routes - HARUS LOGIN
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Resource routes
    Route::resource('penduduk', PendudukController::class);
    Route::resource('kelahiran', KelahiranController::class);
    Route::resource('orangtua', OrangTuaController::class);
    Route::resource('user', UserController::class);
    Route::resource('pelanggan', PelangganController::class);
    // Routes Kematian (tambahkan ini)
Route::resource('kematian', KematianController::class)->except(['show']);

// Routes tambahan untuk Kematian
Route::get('kematian/{kematian}', [KematianController::class, 'show'])->name('kematian.show');
Route::get('kematian/penduduk/{id}', [KematianController::class, 'getPendudukData'])->name('kematian.get-penduduk');
Route::get('kematian/report/generate', [KematianController::class, 'report'])->name('kematian.report');

// Route untuk create dengan parameter penduduk_id
Route::get('kematian/create/{penduduk_id?}', [KematianController::class, 'create'])->name('kematian.create');

// Route untuk laporan bulanan
Route::get('kematian/report/bulanan', [KematianController::class, 'reportBulanan'])->name('kematian.report.bulanan');

// Route untuk statistik
Route::get('kematian/statistik', [KematianController::class, 'statistik'])->name('kematian.statistik');
});
