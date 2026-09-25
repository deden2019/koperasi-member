@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        
        <!-- HEADER & TOMBOL KEMBALI -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-3xl shadow-sm mb-8 gap-4 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Riwayat Transaksi</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Daftar seluruh riwayat belanja atau transaksi Anda.</p>
                </div>
            </div>

            <!-- Tombol Kembali ke Dashboard -->
            <a href="/dashboard" class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition text-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- DAFTAR TRANSAKSI -->
        <div class="space-y-4">
            @forelse($transaksi as $item)
                <!-- Kartu Transaksi dibungkus tag <a> agar bisa diklik -->
                <a href="/transaksi/{{ $item->jual_id }}" class="block bg-white p-6 rounded-3xl shadow-sm border border-gray-100 transition hover:shadow-md hover:border-emerald-200 group">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-start gap-4">
                            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl mt-1 group-hover:bg-emerald-600 group-hover:text-white transition">
                                <i class="fa-solid fa-receipt text-lg"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">No. Nota</span>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-emerald-600 transition">{{ $item->nota }}</h3>
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar"></i> {{ date('d-m-Y', strtotime($item->tanggal)) }}
                                </p>
                            </div>
                        </div>

                        <div class="w-full sm:w-auto flex justify-between sm:flex-col items-center sm:items-end border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                            <span class="text-xs text-gray-400 font-medium">Total Pembayaran</span>
                            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($item->total_nota,0,',','.') }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <!-- Tampilan Jika Kosong -->
                <div class="bg-white p-12 rounded-3xl shadow-sm border border-gray-100 text-center">
                    <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1">Tidak Ada Transaksi</h3>
                    <p class="text-sm text-gray-400">Belum ada riwayat transaksi yang tercatat pada akun Anda.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection