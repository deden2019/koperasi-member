@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-5">
    
    <!-- TOP HEADER & BREADCRUMB / NAVIGASI -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-tokopedia-light text-tokopedia flex items-center justify-center text-lg font-bold">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800 tracking-tight">Daftar Transaksi</h1>
                <p class="text-xs text-gray-500">Pantau dan cek seluruh riwayat belanja atau transaksi Anda</p>
            </div>
        </div>

        <!-- Tombol Kembali ke Dashboard -->
        <a href="/dashboard" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold rounded-xl text-xs border border-gray-200 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Beranda
        </a>
    </div>

   <!-- FILTER & SEARCH BAR KHAS TOKOPEDIA -->
<div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 space-y-4">
    
    <!-- Tab Status Pesanan (Menggunakan Query Parameter 'status') -->
<!-- Tab Status Pesanan (Menggunakan Query Parameter 'status') -->
<div class="flex items-center gap-2 border-b border-gray-100 pb-3 overflow-x-auto text-xs sm:text-sm font-semibold text-gray-500 whitespace-nowrap scrollbar-none">
    @php 
        // Default ke 'semua' jika parameter kosong
        $status = request('status', 'semua'); 
    @endphp
    
    <a href="{{ request()->fullUrlWithQuery(['status' => 'semua']) }}" 
       class="px-4 py-1.5 rounded-full transition {{ in_array($status, ['semua', '']) ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'hover:bg-gray-100 hover:text-gray-800' }}">
        Semua Status
    </a>
    
    <!-- Ubah value 'belum_lunas' menjadi 'belum lunas' agar sesuai dengan pengecekan di controller -->
    <a href="{{ request()->fullUrlWithQuery(['status' => 'belum lunas']) }}" 
       class="px-4 py-1.5 rounded-full transition {{ $status == 'belum lunas' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'hover:bg-gray-100 hover:text-gray-800' }}">
        Belum Lunas
    </a>
    
    <a href="{{ request()->fullUrlWithQuery(['status' => 'lunas']) }}" 
       class="px-4 py-1.5 rounded-full transition {{ $status == 'lunas' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'hover:bg-gray-100 hover:text-gray-800' }}">
        Lunas
    </a>
</div>

    <!-- Form Input Search & Filter Tanggal -->
    <form action="{{ url()->current() }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <!-- Preserve status jika tab aktif -->
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif

        <!-- Input Search Nota -->
        <div class="relative flex-1">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari berdasarkan No. Nota..." 
                   class="w-full pl-9 pr-10 py-2 text-xs sm:text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:bg-white transition">
            
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-xs"></i>

            @if(request('search'))
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif
        </div>

        <!-- Filter Tanggal -->
        <div class="flex gap-2">
            <input type="date" 
                   name="tanggal" 
                   value="{{ request('tanggal') }}" 
                   onchange="this.form.submit()" 
                   class="px-3 py-2 text-xs font-semibold text-gray-600 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 focus:outline-none focus:border-emerald-500 transition cursor-pointer">
            
            @if(request('search') || request('tanggal') || (request('status') && request('status') !== 'semua'))
                <a href="{{ url()->current() }}" class="flex items-center justify-center px-3 py-2 text-xs font-bold text-rose-600 bg-rose-50 border border-rose-100 rounded-xl hover:bg-rose-100 transition" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                </a>
            @endif
        </div>
    </form>

</div>
    <!-- DAFTAR TRANSAKSI (LIST PESANAN) -->
    <div class="space-y-4">
        @forelse($transaksi as $item)
            <!-- KARTU PESANAN KHAS TOKOPEDIA -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:border-tokopedia/60 transition duration-200 overflow-hidden">
                
                <!-- HEADER KARTU: TANGGAL & STATUS -->
                <div class="px-5 py-3 bg-gray-50/70 border-b border-gray-100 flex flex-wrap items-center justify-between gap-2 text-xs text-gray-500">
                    <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 font-medium text-gray-700">
                            <i class="fa-solid fa-bag-shopping text-tokopedia"></i> Belanja
                        </span>
                        <span class="text-gray-300 hidden sm:inline">•</span>
                        <span>{{ date('d M Y', strtotime($item->tanggal)) }}</span>
                        <span class="text-gray-300 hidden sm:inline">•</span>
                        <span class="font-mono text-gray-500 bg-gray-200/60 px-2 py-0.5 rounded text-[11px]">{{ $item->nota }}</span>
                    </div>

                    <!-- Badge Status Tokopedia -->
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-tokopedia border border-tokopedia/20">
                        <i class="fa-solid fa-circle-check text-[9px]"></i> Selesai
                    </span>
                </div>

                <!-- BODY KARTU: DETAIL & TOTAL -->
                <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    
                    <!-- Sisi Kiri: Informasi Barang / Nota -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-tokopedia-light text-tokopedia flex items-center justify-center shrink-0 border border-tokopedia/20">
                            <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-sm sm:text-base font-bold text-gray-800 hover:text-tokopedia cursor-pointer transition">
                                Pembelian Koperasi - {{ $item->nota }}
                            </h3>
                            <p class="text-xs text-gray-500">
                                Transaksi berhasil diproses oleh sistem Koperasi RSPB.
                            </p>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Harga & Action Button -->
                    <div class="flex md:flex-col items-center md:items-end justify-between border-t md:border-t-0 pt-3 md:pt-0 border-gray-100 gap-2">
                        <div class="text-left md:text-right">
                            <p class="text-[11px] text-gray-400 font-medium">Total Belanja</p>
                            <p class="text-base sm:text-lg font-bold text-gray-900">
                                Rp {{ number_format($item->total_nota, 0, ',', '.') }}
                            </p>
                        </div>

                        <a href="/transaksi/{{ $item->jual_id }}" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-tokopedia hover:bg-tokopedia-hover text-white text-xs font-semibold rounded-xl shadow-sm transition">
                            Lihat Detail Nota
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>

                </div>

            </div>
        @empty
            <!-- TAMPILAN JIKA KOSONG (EMPTY STATE) -->
            <div class="bg-white p-12 rounded-2xl shadow-sm border border-gray-100 text-center max-w-md mx-auto my-8">
                <div class="w-20 h-20 bg-emerald-50 text-tokopedia rounded-full flex items-center justify-center mx-auto mb-4 text-3xl border border-tokopedia/20">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-1">Belum Ada Transaksi</h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-6">
                    Riwayat belanja atau pembayaran transaksi Anda di Koperasi RSPB akan muncul di sini.
                </p>
                <a href="/dashboard" class="inline-flex items-center gap-2 px-5 py-2.5 bg-tokopedia hover:bg-tokopedia-hover text-white text-xs font-bold rounded-xl shadow-sm transition">
                    Mulai Belanja / Ke Beranda
                </a>
            </div>
        @endforelse
    </div>

</div>
@endsection