@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- HEADER / SELAMAT DATANG -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl font-bold">
            {{ strtoupper(substr($dashboard->nama_customer, 0, 1)) }}
        </div>
        <div>
            <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Selamat Datang,</span>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $dashboard->nama_customer }}</h2>
        </div>
    </div>

    <!-- KARTU STATISTIK (GRID) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Kartu 1: Kode Anggota -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                    <i class="fa-solid fa-id-card text-xl"></i>
                </div>
                <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full">ID Anggota</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium mb-1">Kode Anggota</p>
                <h3 class="text-2xl font-bold text-gray-900 tracking-wide">{{ $dashboard->kode_customer }}</h3>
            </div>
        </div>

        <!-- Kartu 2: Jumlah Transaksi -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                    <i class="fa-solid fa-receipt text-xl"></i>
                </div>
                <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Aktivitas</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium mb-1">Jumlah Transaksi</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ $dashboard->jumlah_transaksi }} <span class="text-sm font-normal text-gray-500">kali</span></h3>
            </div>
        </div>

        <!-- Kartu 3: Total Belanja -->
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white p-6 rounded-3xl shadow-lg shadow-emerald-600/20 flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-white/10 text-white rounded-2xl backdrop-blur-md">
                    <i class="fa-solid fa-wallet text-xl"></i>
                </div>
                <span class="text-xs font-medium text-emerald-100 bg-white/10 px-2.5 py-1 rounded-full backdrop-blur-md">Total Pengeluaran</span>
            </div>
            <div>
                <p class="text-sm text-emerald-100 font-medium mb-1">Total Belanja</p>
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight">Rp {{ number_format($dashboard->total_belanja,0,',','.') }}</h3>
            </div>
        </div>

        <!-- Kartu 4: Belanja Bulan Ini -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-2xl">
                    <i class="fa-solid fa-calendar-days text-xl"></i>
                </div>
                <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full">Bulan Ini</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium mb-1">Belanja Bulan Ini</p>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Rp {{ number_format($bulanIni,0,',','.') }}</h3>
            </div>
        </div>

        <!-- Kartu 5: Total Piutang -->
        <a href="/piutang" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden hover:shadow-md hover:border-rose-200 transition group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl group-hover:scale-110 transition">
                    <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                </div>
                <span class="text-xs font-medium text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">Sisa Tagihan</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium mb-1">Total Piutang</p>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Rp {{ number_format($totalPiutang,0,',','.') }}</h3>
            </div>
        </a>

        <!-- Kartu 6: Piutang Terbayar -->
        <a href="/piutang/terbayar" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden hover:shadow-md hover:border-teal-200 transition group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-teal-50 text-teal-600 rounded-2xl group-hover:scale-110 transition">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>
                <span class="text-xs font-medium text-teal-600 bg-teal-50 px-2.5 py-1 rounded-full">Riwayat Bayar</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium mb-1">Pembayaran</p>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Rp {{ number_format($totalTerbayar,0,',','.') }}</h3>
            </div>
        </a>

        <!-- Kartu 7: Plafon Piutang (Baru) -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <i class="fa-solid fa-chart-pie text-xl"></i>
                </div>
                <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">Limit Plafon</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium mb-1">Plafon Piutang</p>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Rp {{ number_format($dashboard->plafon_piutang,0,',','.') }}</h3>
            </div>
        </div>

        <!-- Kartu 8: Sisa Limit (Baru) -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <i class="fa-solid fa-shield-halved text-xl"></i>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Tersedia</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium mb-1">Sisa Limit</p>
                <h3 class="text-xl sm:text-2xl font-bold text-emerald-600">Rp {{ number_format($sisaLimit,0,',','.') }}</h3>
            </div>
        </div>

    </div>

    <!-- TRANSAKSI TERAKHIR -->
    @if($transaksiTerakhir)
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gray-50 text-gray-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">Transaksi Terakhir</span>
                <h4 class="font-bold text-gray-900">Rp {{ number_format($transaksiTerakhir->total_nota,0,',','.') }}</h4>
            </div>
        </div>
        <div class="text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-xl">
            <i class="fa-regular fa-calendar mr-1.5 text-emerald-600"></i> {{ date('d-m-Y H:i', strtotime($transaksiTerakhir->tanggal)) }}
        </div>
    </div>
    @endif

    <!-- MENU NAVIGASI UTAMA -->
    <div class="mb-4 mt-10">
        <h3 class="text-lg font-bold text-gray-900">Menu Navigasi</h3>
        <p class="text-xs text-gray-400">Pilih menu di bawah untuk mengelola akun Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        
        <!-- Menu 1: Riwayat Transaksi -->
        <a href="/transaksi" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-100 transition flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Riwayat Transaksi</h4>
                    <p class="text-sm text-gray-500">Lihat pembelian</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-blue-600 transition"></i>
        </a>

        <!-- Menu 2: Riwayat Pembayaran -->
        <a href="/riwayat-pembayaran" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-100 transition flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Riwayat Pembayaran</h4>
                    <p class="text-sm text-gray-500">Tunai, QRIS & Piutang</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-purple-600 transition"></i>
        </a>

        <!-- Menu 3: Profil Saya -->
        <a href="/profile" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-100 transition flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Profil Saya</h4>
                    <p class="text-sm text-gray-500">Data anggota</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-green-600 transition"></i>
        </a>

        <!-- Menu 4: Ganti PIN -->
        <a href="/change-pin" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md hover:border-red-100 transition flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Ganti PIN</h4>
                    <p class="text-sm text-gray-500">Ubah PIN akun</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-red-600 transition"></i>
        </a>

    </div>

</div>
@endsection