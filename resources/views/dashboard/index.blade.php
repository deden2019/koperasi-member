@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6">

    <!-- 1. HEADER USER & RINGKASAN FINANSIAL -->
    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- User Info -->
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-emerald-100 border-2 border-emerald-500 flex items-center justify-center text-emerald-700 font-bold text-xl sm:text-2xl flex-shrink-0 shadow-inner">
                    {{ strtoupper(substr($dashboard->nama_customer, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-base sm:text-xl font-bold text-gray-900 leading-tight">
                            {{ $dashboard->nama_customer }}
                        </h1>
                        <span class="bg-emerald-50 text-emerald-700 text-[10px] sm:text-xs font-bold px-2 py-0.5 rounded-full border border-emerald-200">
                            Verified
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 font-mono mt-0.5">ID: {{ $dashboard->kode_customer }}</p>
                </div>
            </div>

            <!-- Financial Summary Bar & Action PDF -->
            <div class="flex flex-col gap-2">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 sm:gap-3 bg-gray-50 p-2.5 sm:p-3 rounded-xl border border-gray-100">
                    <div class="px-2 border-r border-gray-200">
                        <span class="text-[10px] sm:text-xs text-gray-500 block">Sisa Limit</span>
                        <span class="text-xs sm:text-sm font-bold text-emerald-600 block truncate">
                            Rp {{ number_format($sisaLimit, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="px-2 border-r border-gray-200 sm:border-r-0 md:border-r">
                        <span class="text-[10px] sm:text-xs text-gray-500 block">Sisa Tagihan</span>
                        <span class="text-xs sm:text-sm font-bold text-rose-600 block truncate">
                            Rp {{ number_format($totalPiutang, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="col-span-2 sm:col-span-1 px-2 pt-1 sm:pt-0 border-t sm:border-t-0 border-gray-200">
                        <span class="text-[10px] sm:text-xs text-gray-500 block">Plafon Kredit</span>
                        <span class="text-xs sm:text-sm font-bold text-gray-800 block truncate">
                            Rp {{ number_format($dashboard->plafon_piutang, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Tombol Action PDF Piutang (View & Download) -->
                @if(isset($dashboard->file_pdf_piutang) && $dashboard->file_pdf_piutang)
                <div class="flex items-center justify-end gap-2 pt-1">
                    <span class="text-[11px] font-medium text-gray-500">File Piutang:</span>
                    
                    <!-- Tombol Lihat PDF -->
                    <a href="{{ asset('storage/' . $dashboard->file_pdf_piutang) }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 text-xs font-semibold transition shadow-sm">
                        <i class="fa-solid fa-file-pdf text-red-500"></i>
                        <span>Lihat PDF</span>
                    </a>

                    <!-- Tombol Download PDF -->
                    <a href="{{ asset('storage/' . $dashboard->file_pdf_piutang) }}" 
                       download 
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 text-xs font-semibold transition shadow-sm">
                        <i class="fa-solid fa-download"></i>
                        <span>Download</span>
                    </a>
                </div>
                @endif
            </div>

        </div>
    </div>

    <!-- ==================== JUMBOTRON BANNER CAROUSEL (TOKOPEDIA STYLE) ==================== -->
    <div class="relative group">
        <div class="swiper bannerSwiper rounded-2xl overflow-hidden shadow-sm border border-gray-200">
            <div class="swiper-wrapper">
                
                <!-- Slide 1: Promo / Info Limit -->
                <div class="swiper-slide">
                    <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-800 text-white p-6 sm:p-8 min-h-[160px] sm:min-h-[200px] flex items-center justify-between relative overflow-hidden">
                        <div class="relative z-10 max-w-lg">
                            <span class="bg-white/20 text-white text-[10px] sm:text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-md uppercase tracking-wider mb-2 inline-block">
                                Informasi Anggota
                            </span>
                            <h3 class="text-lg sm:text-2xl font-extrabold mb-1">Gunakan Limit Kredit Anda!</h3>
                            <p class="text-xs sm:text-sm text-emerald-100 mb-4">Sisa limit belanja Anda sebesar <strong class="text-white">Rp {{ number_format($sisaLimit, 0, ',', '.') }}</strong> masih dapat digunakan.</p>
                            <a href="/transaksi" class="inline-flex items-center gap-2 bg-white text-emerald-700 hover:bg-emerald-50 text-xs sm:text-sm font-bold px-4 py-2 rounded-xl transition shadow-sm">
                                Belanja Sekarang <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="absolute -right-6 -bottom-8 opacity-20 text-white text-9xl pointer-events-none">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Cashier / Pembayaran -->
                <div class="swiper-slide">
                    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-800 text-white p-6 sm:p-8 min-h-[160px] sm:min-h-[200px] flex items-center justify-between relative overflow-hidden">
                        <div class="relative z-10 max-w-lg">
                            <span class="bg-white/20 text-white text-[10px] sm:text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-md uppercase tracking-wider mb-2 inline-block">
                                Tagihan & Piutang
                            </span>
                            <h3 class="text-lg sm:text-2xl font-extrabold mb-1">Bayar Tagihan Lebih Praktis</h3>
                            <p class="text-xs sm:text-sm text-blue-100 mb-4">Cek riwayat transaksi dan status pembayaran piutang Anda secara real-time.</p>
                            <a href="/riwayat-pembayaran" class="inline-flex items-center gap-2 bg-white text-blue-700 hover:bg-blue-50 text-xs sm:text-sm font-bold px-4 py-2 rounded-xl transition shadow-sm">
                                Cek Riwayat Bayar <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="absolute -right-6 -bottom-8 opacity-20 text-white text-9xl pointer-events-none">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Keamanan -->
                <div class="swiper-slide">
                    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 text-white p-6 sm:p-8 min-h-[160px] sm:min-h-[200px] flex items-center justify-between relative overflow-hidden">
                        <div class="relative z-10 max-w-lg">
                            <span class="bg-white/20 text-white text-[10px] sm:text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-md uppercase tracking-wider mb-2 inline-block">
                                Keamanan Akun
                            </span>
                            <h3 class="text-lg sm:text-2xl font-extrabold mb-1">Lindungi Akun Anda</h3>
                            <p class="text-xs sm:text-sm text-amber-100 mb-4">Perbarui PIN Anda secara berkala untuk menjaga keamanan transaksi keanggotaan.</p>
                            <a href="/change-pin" class="inline-flex items-center gap-2 bg-white text-orange-700 hover:bg-orange-50 text-xs sm:text-sm font-bold px-4 py-2 rounded-xl transition shadow-sm">
                                Ganti PIN <i class="fa-solid fa-shield-halved"></i>
                            </a>
                        </div>
                        <div class="absolute -right-6 -bottom-8 opacity-20 text-white text-9xl pointer-events-none">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Pagination Dots -->
            <div class="swiper-pagination !bottom-3"></div>

            <!-- Navigasi Panah Kiri-Kanan -->
            <div class="swiper-button-prev !w-8 !h-8 !bg-white/80 hover:!bg-white !text-gray-800 rounded-full shadow-md after:!text-xs opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="swiper-button-next !w-8 !h-8 !bg-white/80 hover:!bg-white !text-gray-800 rounded-full shadow-md after:!text-xs opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>
    </div>
    <!-- ==================== END JUMBOTRON BANNER ==================== -->
<!-- 2. QUICK MENU / NAVIGASI CEPAT -->
<div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Menu Utama</h2>
    
    <div class="grid grid-cols-5 gap-1.5 sm:gap-4 text-center">
        
        <!-- 1. Riwayat Transaksi -->
        <a href="/transaksi" class="flex flex-col items-center group p-1.5 sm:p-2 rounded-xl hover:bg-gray-50 transition">
            <div class="w-10 h-10 sm:w-13 sm:h-13 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-base sm:text-xl mb-1.5 group-hover:scale-105 transition shadow-sm">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <span class="text-[10px] sm:text-xs font-semibold text-gray-700 leading-tight">Riwayat Transaksi</span>
        </a>

        <!-- 2. Riwayat Bayar -->
        <a href="/riwayat-pembayaran" class="flex flex-col items-center group p-1.5 sm:p-2 rounded-xl hover:bg-gray-50 transition">
            <div class="w-10 h-10 sm:w-13 sm:h-13 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-base sm:text-xl mb-1.5 group-hover:scale-105 transition shadow-sm">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <span class="text-[10px] sm:text-xs font-semibold text-gray-700 leading-tight">Riwayat Bayar</span>
        </a>

<!-- 3. TOMBOL DINAMIS: UPLOAD PDF (KHUSUS DEDEN 08115965955) / PDF PIUTANG (CLIENT) -->
@php
    // Ambil nomor telepon dari objek $dashboard yang sudah diambil di DashboardController
    $userPhone = $dashboard->telepon 
              ?? $dashboard->no_hp 
              ?? $dashboard->hp 
              ?? auth()->user()->telepon 
              ?? session('telepon') 
              ?? '';

    // Bersihkan karakter selain angka
    $cleanPhone = preg_replace('/[^0-9]/', '', $userPhone);

    $hasPdf = isset($dashboard->file_pdf_piutang) && !empty($dashboard->file_pdf_piutang);
@endphp

@if($cleanPhone === '08115965955')
    <!-- Tombol Upload PDF Khusus Admin Deden -->
    <a href="{{ route('admin.upload-pdf.index') }}" 
       class="flex flex-col items-center group p-1.5 sm:p-2 rounded-xl hover:bg-gray-50 transition">
        <div class="w-10 h-10 sm:w-13 sm:h-13 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-base sm:text-xl mb-1.5 group-hover:scale-105 transition shadow-sm">
            <i class="fa-solid fa-cloud-arrow-up"></i>
        </div>
        <span class="text-[10px] sm:text-xs font-semibold text-gray-700 leading-tight">Upload PDF</span>
    </a>
@else
    <!-- Tombol Lihat PDF untuk Client / Member Biasa -->
    <a href="{{ $hasPdf ? asset('storage/' . $dashboard->file_pdf_piutang) : 'javascript:void(0);' }}" 
       @if($hasPdf) target="_blank" @else onclick="alert('File PDF Piutang belum tersedia/belum diunggah.')" @endif
       class="flex flex-col items-center group p-1.5 sm:p-2 rounded-xl hover:bg-gray-50 transition">
        <div class="w-10 h-10 sm:w-13 sm:h-13 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-base sm:text-xl mb-1.5 group-hover:scale-105 transition shadow-sm">
            <i class="fa-solid fa-file-pdf"></i>
        </div>
        <span class="text-[10px] sm:text-xs font-semibold text-gray-700 leading-tight">PDF Piutang</span>
    </a>
@endif
        <!-- 4. Profil Saya -->
        <a href="/profile" class="flex flex-col items-center group p-1.5 sm:p-2 rounded-xl hover:bg-gray-50 transition">
            <div class="w-10 h-10 sm:w-13 sm:h-13 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base sm:text-xl mb-1.5 group-hover:scale-105 transition shadow-sm">
                <i class="fa-solid fa-user"></i>
            </div>
            <span class="text-[10px] sm:text-xs font-semibold text-gray-700 leading-tight">Profil Saya</span>
        </a>

        <!-- 5. Ganti PIN -->
        <a href="/change-pin" class="flex flex-col items-center group p-1.5 sm:p-2 rounded-xl hover:bg-gray-50 transition">
            <div class="w-10 h-10 sm:w-13 sm:h-13 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-base sm:text-xl mb-1.5 group-hover:scale-105 transition shadow-sm">
                <i class="fa-solid fa-lock"></i>
            </div>
            <span class="text-[10px] sm:text-xs font-semibold text-gray-700 leading-tight">Ganti PIN</span>
        </a>

    </div>
</div>

    <!-- 3. DETAIL STATISTIK KEUANGAN & AKTIVITAS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div class="col-span-2 lg:col-span-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white p-4 sm:p-5 rounded-2xl shadow-sm relative overflow-hidden flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="text-xs text-emerald-100 block font-medium">Akumulasi Belanja</span>
                    <h3 class="text-xl sm:text-2xl font-extrabold tracking-tight mt-0.5">
                        Rp {{ number_format($dashboard->total_belanja, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <p class="text-[11px] text-emerald-100 flex items-center gap-1">
                <i class="fa-solid fa-circle-check"></i> Total dari {{ $dashboard->jumlah_transaksi }}x transaksi
            </p>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-gray-400">Bulan Ini</span>
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-0.5">Pengeluaran</p>
                <h4 class="text-sm sm:text-base font-bold text-gray-900 truncate">
                    Rp {{ number_format($bulanIni, 0, ',', '.') }}
                </h4>
            </div>
        </div>

        <a href="/piutang/terbayar" class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm hover:border-teal-300 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-gray-400">Terbayar</span>
                <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-0.5">Total Bayar</p>
                <h4 class="text-sm sm:text-base font-bold text-teal-600 truncate">
                    Rp {{ number_format($totalTerbayar, 0, ',', '.') }}
                </h4>
            </div>
        </a>
    </div>

    <!-- 4. BANNER TRANSAKSI TERAKHIR -->
    @if($transaksiTerakhir)
    <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center flex-shrink-0 text-sm">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="truncate">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Transaksi Terakhir</span>
                <h4 class="text-sm font-bold text-gray-900 truncate">
                    Rp {{ number_format($transaksiTerakhir->total_nota, 0, ',', '.') }}
                </h4>
            </div>
        </div>
        <div class="text-[11px] text-gray-500 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100 flex-shrink-0 whitespace-nowrap">
            <i class="fa-regular fa-calendar text-emerald-600 mr-1"></i> 
            {{ date('d/m/Y H:i', strtotime($transaksiTerakhir->tanggal)) }}
        </div>
    </div>
    @endif

</div>

<!-- SCRIPT INISIALISASI SWIPER CAROUSEL -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var swiper = new Swiper(".bannerSwiper", {
            spaceBetween: 16,
            centeredSlides: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            loop: true,
        });
    });
</script>

<style>
    .swiper-pagination-bullet-active {
        background-color: #ffffff !important;
        width: 18px !important;
        border-radius: 4px !important;
    }
    .swiper-pagination-bullet {
        background-color: rgba(255, 255, 255, 0.6);
    }
</style>
@endsection