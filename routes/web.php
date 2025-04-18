<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BankMiniController;


Route::post('/siswa/transaction', [SiswaController::class, 'store'])->name('siswa.transaction.store');
Route::post('/admin/transaction', [TransactionController::class, 'store'])->name('admin.transaction.store'); 
Route::post('/admin/tambah-user', [AdminController::class, 'tambahUser'])->name('admin.tambah.user');

Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('admin.users');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard Admin
    Route::get('/admin', [AdminController::class, 'showUsers'])->name('admin.dashboard');
    
    // Dashboard Bank Mini
Route::get('/bank_mini/transactions', [BankMiniController::class, 'index'])->name('bankmini.dashboard');

     // Dashboard Siswa
    Route::get('/siswa', function () {
        return view('dashboard.siswa');
    })->name('siswa.dashboard');
});