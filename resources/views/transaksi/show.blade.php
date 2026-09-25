@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        
        <!-- HEADER & TOMBOL KEMBALI -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-3xl shadow-sm mb-8 gap-4 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
                <div>
                    <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Detail Transaksi</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $transaksi->nota }}</h2>
                </div>
            </div>

            <!-- Tombol Kembali ke Riwayat Transaksi -->
            <a href="/transaksi" class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition text-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
            </a>
        </div>

        <!-- INFORMASI UTAMA NOTA -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <p class="text-xs text-gray-400 font-medium mb-1">Tanggal Transaksi</p>
                <p class="text-base font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-emerald-600"></i> {{ date('d-m-Y', strtotime($transaksi->tanggal)) }}
                </p>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <p class="text-xs text-gray-400 font-medium mb-1">Total Pembayaran</p>
                <p class="text-xl font-bold text-emerald-600">
                    Rp {{ number_format($transaksi->total_nota, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- DAFTAR ITEM PRODUK -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-gray-900 text-lg">Daftar Produk</h3>
                <p class="text-xs text-gray-400">Rincian barang yang dibeli pada transaksi ini.</p>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($items as $item)
                    <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-gray-50/50 transition">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl mt-0.5">
                                <i class="fa-solid fa-box text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $item->nama_produk }}</h4>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $item->jumlah }} item × Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                    @if($item->diskon > 0)
                                        <span class="text-red-500 font-medium ml-1">(Diskon: Rp {{ number_format($item->diskon, 0, ',', '.') }})</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="w-full sm:w-auto flex justify-between sm:flex-col items-center sm:items-end border-t sm:border-t-0 pt-2 sm:pt-0 border-gray-100">
                            <span class="text-xs text-gray-400 font-medium sm:hidden">Subtotal</span>
                            <span class="font-bold text-gray-900">
                                Rp {{ number_format(($item->jumlah * $item->harga_jual) - $item->diskon, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-400">
                        <p class="text-sm">Tidak ada produk ditemukan untuk transaksi ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection