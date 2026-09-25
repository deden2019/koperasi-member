@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">


<!-- TOMBOL KEMBALI -->
    <div class="mb-4">
        <a href="/dashboard" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-emerald-600 transition bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
    
    <!-- HEADER / JUDUL HALAMAN -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <span class="text-xs font-bold tracking-wider text-indigo-600 uppercase">Riwayat</span>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Riwayat Pembayaran</h2>
            </div>
        </div>
        <p class="text-sm text-gray-400">
            Tunai, QRIS, Kartu, dan Pembayaran Piutang
        </p>
    </div>

    <!-- DAFTAR TRANSAKSI -->
    <div class="space-y-4">
        @forelse($transaksi as $item)
            @php
                $metode = 'Tidak Diketahui';
                $badgeColor = 'bg-gray-50 text-gray-600';
                
                if($item->bayar_tunai > 0){
                    $metode = 'Tunai';
                    $badgeColor = 'bg-emerald-50 text-emerald-600';
                }
                if($item->bayar_kartu > 0){
                    $metode = 'QRIS / Kartu';
                    $badgeColor = 'bg-blue-50 text-blue-600';
                }
                if($item->total_nota > $item->total_pelunasan){
                    $metode = 'Piutang';
                    $badgeColor = 'bg-rose-50 text-rose-600';
                }
            @endphp

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 items-center">
                    
                    <!-- Kolom 1: Nota -->
                    <div>
                        <span class="text-xs font-medium text-gray-400 block mb-1">Nota</span>
                        @if(isset($item->id))
                            <a href="/transaksi/{{ $item->id }}" class="font-bold text-indigo-600 hover:text-indigo-700 hover:underline tracking-wide inline-flex items-center gap-1">
                                {{ $item->nota }}
                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                            </a>
                        @else
                            <span class="font-bold text-gray-900 tracking-wide">{{ $item->nota }}</span>
                        @endif
                    </div>

                    <!-- Kolom 2: Tanggal -->
                    <div>
                        <span class="text-xs font-medium text-gray-400 block mb-1">Tanggal</span>
                        <div class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-gray-400"></i>
                            {{ date('d-m-Y', strtotime($item->tanggal)) }}
                        </div>
                    </div>

                    <!-- Kolom 3: Metode -->
                    <div>
                        <span class="text-xs font-medium text-gray-400 block mb-1">Metode</span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium inline-block {{ $badgeColor }}">
                            {{ $metode }}
                        </span>
                    </div>

                    <!-- Kolom 4: Total -->
                    <div>
                        <span class="text-xs font-medium text-gray-400 block mb-1">Total</span>
                        <span class="text-sm font-bold text-gray-900">
                            Rp {{ number_format($item->total_nota, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Kolom 5: Status -->
                    <div class="col-span-2 sm:col-span-1 lg:text-right pt-2 lg:pt-0 border-t lg:border-t-0 border-gray-100 flex lg:flex-col justify-between items-center lg:items-end">
                        <span class="text-xs font-medium text-gray-400 block mb-1">Status</span>
                        @if($item->total_pelunasan >= $item->total_nota)
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-circle-check text-xs"></i> Lunas
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">
                                <i class="fa-solid fa-clock text-xs"></i> Belum Lunas
                            </span>
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-3xl flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">Belum Ada Riwayat Pembayaran</h3>
                <p class="text-sm text-gray-400">Belum ada data transaksi pembayaran yang tercatat.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection