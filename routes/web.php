<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\PembayaranController;

// 1. Landing Page Utama
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute Login & Logout Portal Member
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// 3. Area Khusus Member Terautentikasi
Route::middleware('member.auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/{jualId}', [TransaksiController::class, 'show']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::post('/profile/update', [ProfileController::class, 'update']);

    // Ubah PIN
    Route::get('/change-pin', [PinController::class, 'index']);
    Route::post('/change-pin', [PinController::class, 'update']);

    // Kartu Anggota
    Route::get('/card', [CardController::class, 'index']);

    // Piutang & Pembayaran
    Route::get('/piutang', [PiutangController::class, 'index']);
    Route::get('/piutang/terbayar', [PiutangController::class, 'terbayar']);
    Route::get('/riwayat-pembayaran', [PembayaranController::class, 'index']);

});