@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-5">
    
    <!-- TOP HEADER / NAVIGASI KEMBALI -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3.5">
            <a href="/transaksi" class="w-9 h-9 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 flex items-center justify-center transition shrink-0" title="Kembali">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-lg sm:text-xl font-bold text-gray-800 tracking-tight">Detail Transaksi</h1>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-tokopedia border border-tokopedia/20">
                        <i class="fa-solid fa-circle-check text-[9px]"></i> Selesai
                    </span>
                </div>
                <p class="text-xs text-gray-500 font-mono mt-0.5">No. Invoice: <span class="font-bold text-gray-700">{{ $transaksi->nota }}</span></p>
            </div>
        </div>

        <!-- PERBAIKAN: DIGANTI MENJADI LINK KE ROUTE PRINT INVOICE -->
        <a href="/transaksi/{{ $transaksi->jual_id }}/print" 
           target="_blank" 
           class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold rounded-xl text-xs border border-gray-200 transition">
            <i class="fa-solid fa-print text-xs"></i> Cetak Invoice
        </a>
    </div>

    <!-- MAIN CONTENT GRID (DESKTOP: 2 KOLOM, MOBILE: 1 KOLOM) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <!-- KOLOM KIRI (2/3): DAFTAR PRODUK & DETAIL PENGIRIMAN/PEMBELIAN -->
        <div class="lg:col-span-2 space-y-5">
            
            <!-- CARD DAFTAR PRODUK -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bag-shopping text-tokopedia text-sm"></i>
                        <h2 class="font-bold text-gray-800 text-sm">Detail Produk</h2>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">{{ count($items) }} Barang</span>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($items as $item)
                        <div class="p-5 flex flex-col sm:flex-row items-start justify-between gap-4 hover:bg-gray-50/30 transition">
                            
                            <!-- Informasi Produk -->
                            <div class="flex items-start gap-3.5">
                                <div class="w-12 h-12 rounded-xl bg-tokopedia-light text-tokopedia flex items-center justify-center shrink-0 border border-tokopedia/20 text-lg">
                                    <i class="fa-solid fa-box-archive"></i>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="font-bold text-gray-800 text-sm sm:text-base leading-snug">
                                        {{ $item->nama_produk }}
                                    </h3>
                                    <p class="text-xs text-gray-500">
                                        {{ $item->jumlah }} x <span class="font-semibold text-gray-700">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                    </p>
                                    @if($item->diskon > 0)
                                        <span class="inline-block text-[11px] font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded border border-red-100">
                                            Diskon Rp {{ number_format($item->diskon, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Total Harga Per Item -->
                            <div class="w-full sm:w-auto flex justify-between sm:flex-col items-end border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100 text-right">
                                <span class="text-xs text-gray-400 font-medium sm:hidden">Subtotal</span>
                                <div>
                                    <p class="text-xs text-gray-400 hidden sm:block">Subtotal</p>
                                    <p class="font-bold text-gray-900 text-sm sm:text-base">
                                        Rp {{ number_format(($item->jumlah * $item->harga_jual) - $item->diskon, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-box-open text-3xl mb-2 text-gray-300"></i>
                            <p class="text-xs">Tidak ada item ditemukan dalam nota ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

           <!-- Informasi Pembelian -->
<div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-3">
    <div class="flex items-center gap-2 font-bold text-gray-800 text-sm border-b border-gray-100 pb-3">
        <i class="fa-solid fa-circle-info text-emerald-600"></i>
        <span>Informasi Pembelian</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
        <!-- Tanggal Transaksi (Tanpa Jam) -->
        <div>
            <span class="text-gray-400 block mb-1">Tanggal Transaksi</span>
            <div class="font-semibold text-gray-800 flex items-center gap-1.5">
                <i class="fa-regular fa-calendar text-gray-400"></i>
                {{ date('d F Y', strtotime($transaksi->tanggal)) }}
            </div>
        </div>

        <!-- Metode Pembayaran Dinamis -->
        <div>
            <span class="text-gray-400 block mb-1">Metode Pembayaran</span>
<!-- METODE PEMBAYARAN DINAMIS DARI DATABASE -->
<div class="flex items-center gap-2">
    <i class="fa-solid fa-wallet text-emerald-600"></i>
<span class="font-semibold text-gray-800">
    {{ $transaksi->nama_metode_pembayaran }}
</span>
</div>
        </div>
    </div>
</div>
        </div>

        <!-- KOLOM KANAN (1/3): RINGKASAN BELANJA (STICKY ON DESKTOP) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 sticky top-20 space-y-4">
                <h2 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-3">
                    Ringkasan Pembayaran
                </h2>

                <!-- Breakdown Harga -->
                <div class="space-y-2.5 text-xs text-gray-600">
                    <div class="flex justify-between">
                        <span>Total Harga Barang</span>
                        <span class="font-medium text-gray-800">Rp {{ number_format($transaksi->total_nota, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Layanan</span>
                        <span class="font-semibold text-tokopedia">Bebas Biaya</span>
                    </div>
                </div>

                <hr class="border-dashed border-gray-200">

                <!-- Total Bayar -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-gray-800">Total Tagihan</p>
                        <p class="text-[10px] text-gray-400">Sudah Termasuk PPN</p>
                    </div>
                    <p class="text-lg font-bold text-tokopedia">
                        Rp {{ number_format($transaksi->total_nota, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Action Button -->
                <a href="/transaksi" class="w-full flex items-center justify-center gap-2 py-2.5 bg-tokopedia hover:bg-tokopedia-hover text-white text-xs font-bold rounded-xl shadow-sm transition mt-2">
                    <i class="fa-solid fa-list-check"></i> Lihat Transaksi Lain
                </a>
            </div>
        </div>

    </div>

</div>
@endsection