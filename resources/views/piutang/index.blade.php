@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- HEADER / JUDUL HALAMAN -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
            <div>
                <span class="text-xs font-bold tracking-wider text-rose-600 uppercase">Sisa Tagihan</span>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Piutang Saya</h2>
            </div>
        </div>
        <a href="/dashboard" class="text-sm font-medium text-gray-500 bg-gray-50 hover:bg-gray-100 px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- DAFTAR PIUTANG -->
    <div class="space-y-4">
        @forelse($piutang as $item)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 items-center">
                    
                    <!-- Kolom 1: Nota (Bisa Diklik) -->
                    <div>
                        <span class="text-xs font-medium text-gray-400 block mb-1">Nota</span>
                        <a href="/transaksi/{{ $item->jual_id }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline tracking-wide inline-flex items-center gap-1">
                            {{ $item->nota }}
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                        </a>
                    </div>

                    <!-- Kolom 2: Tanggal Transaksi -->
                    <div>
                        <span class="text-xs font-medium text-gray-400 block mb-1">Tanggal</span>
                        <div class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-gray-400"></i>
                            {{ date('d-m-Y', strtotime($item->tanggal)) }}
                        </div>
                    </div>

                    <!-- Kolom 3: Jatuh Tempo -->
                    <div>
                        <span class="text-xs font-medium text-gray-400 block mb-1">Jatuh Tempo</span>
                        <div class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-amber-500"></i>
                            {{ $item->tanggal_tempo ? date('d-m-Y', strtotime($item->tanggal_tempo)) : '-' }}
                        </div>
                    </div>

                    <!-- Kolom 4: Total Nota -->
                    <div>
                        <span class="text-xs font-medium text-gray-400 block mb-1">Total</span>
                        <span class="text-sm font-bold text-gray-900">Rp {{ number_format($item->total_nota,0,',','.') }}</span>
                    </div>

                    <!-- Kolom 5: Terbayar -->
                    <div>
                        <span class="text-xs font-medium text-gray-400 block mb-1">Terbayar</span>
                        <span class="text-sm font-medium text-emerald-600">Rp {{ number_format($item->total_pelunasan,0,',','.') }}</span>
                    </div>

                    <!-- Kolom 6: Sisa Tagihan -->
                    <div class="col-span-2 sm:col-span-1 lg:col-span-1 flex lg:flex-col justify-between items-center lg:items-start pt-2 lg:pt-0 border-t lg:border-t-0 border-gray-100">
                        <span class="text-xs font-medium text-gray-400 block mb-1">Sisa Piutang</span>
                        <span class="text-base font-extrabold text-rose-600">
                            Rp {{ number_format($item->total_nota - $item->total_pelunasan,0,',','.') }}
                        </span>
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">Tidak Ada Piutang</h3>
                <p class="text-sm text-gray-400">Hebat! Semua tagihan transaksi Anda sudah lunas.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection