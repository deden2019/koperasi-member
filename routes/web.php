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
use App\Http\Controllers\AdminCustomerController;
    use App\Http\Controllers\PushSubscriptionController;

// 1. Landing Page Utama
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute Login & Logout Portal Member
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Area Khusus Member Terautentikasi
Route::middleware('member.auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transaksi (Lengkap dengan fitur Cetak Invoice Tokopedia Style)
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{jualId}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{jualId}/print', [TransaksiController::class, 'print'])->name('transaksi.print');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Ubah PIN
    Route::get('/change-pin', [PinController::class, 'index'])->name('pin.index');
    Route::post('/change-pin', [PinController::class, 'update'])->name('pin.update');

    // Kartu Anggota
    Route::get('/card', [CardController::class, 'index'])->name('card.index');

    // Piutang & Pembayaran
    Route::get('/piutang', [PiutangController::class, 'index'])->name('piutang.index');
    Route::get('/piutang/terbayar', [PiutangController::class, 'terbayar'])->name('piutang.terbayar');
    Route::get('/riwayat-pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');

    // 4. Khusus Admin Deden (Upload PDF Piutang)
    Route::get('/admin/upload-pdf-piutang', [AdminCustomerController::class, 'indexUploadPdf'])->name('admin.upload-pdf.index');
    Route::post('/admin/upload-pdf-piutang', [AdminCustomerController::class, 'storeUploadPdf'])->name('admin.upload-pdf.store');
    Route::delete('/admin/upload-pdf-piutang/{id}', [App\Http\Controllers\AdminCustomerController::class, 'destroyUploadPdf'])->name('admin.upload-pdf.destroy');
    Route::get('/admin/preview-pdf/{id}', [App\Http\Controllers\AdminCustomerController::class, 'previewPdf'])->name('admin.upload-pdf.preview');



    Route::post('/save-push-subscription', [PushSubscriptionController::class, 'store']);

    });