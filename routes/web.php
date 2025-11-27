<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelahiranController;
use App\Http\Controllers\KependudukanController;

//Route::get('/', function () {
    //return view('welcome');
//});


Route::get('/adminpenduduk', [KependudukanController::class, 'index'])->name('kependudukan.index');
Route::get('', [AuthController::class, 'index']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Gunakan resource route dengan nama yang sesuai
Route::resource('penduduk', PendudukController::class);
Route::resource('kelahiran', KelahiranController::class);
// routes/web.php
Route::resource('orangtua', OrangTuaController::class);
