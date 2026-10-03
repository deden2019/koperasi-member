@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- HEADER HALAMAN BERGAYA TOKOPEDIA -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 border border-emerald-100">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-bold text-gray-800 tracking-tight">Piutang & Sisa Tagihan</h1>
                <p class="text-xs text-gray-500 mt-0.5">Daftar transaksi yang memiliki sisa pembayaran</p>
            </div>
        </div>

        <a href="/dashboard" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-semibold rounded-xl border border-gray-200 transition">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- LIST CARD PIUTANG -->
    <div class="space-y-4">
        @forelse($piutang as $item)
            @php
                $sisa = $item->total_nota - $item->total_pelunasan;
                $persenTerbayar = $item->total_nota > 0 ? min(100, round(($item->total_pelunasan / $item->total_nota) * 100)) : 0;
            @endphp

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:border-emerald-300 transition space-y-4">
                
                <!-- TOP STRIP: NOTA & TANGGAL -->
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 pb-3 text-xs">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 font-bold border border-amber-200/60 text-[11px]">
                            <i class="fa-solid fa-clock text-[10px]"></i> Belum Lunas
                        </span>
                        <span class="text-gray-400">|</span>
                        <span class="font-mono font-bold text-gray-700">{{ $item->nota }}</span>
                    </div>

                    <div class="text-gray-500 font-medium flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar text-gray-400"></i>
                        <span>{{ date('d M Y', strtotime($item->tanggal)) }}</span>
                    </div>
                </div>

                <!-- MAIN BODY: BREAKDOWN NILAI -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 items-center">
                    
                    <!-- Total Nota -->
                    <div>
                        <span class="text-[11px] font-medium text-gray-400 block mb-0.5">Total Tagihan</span>
                        <span class="text-sm font-bold text-gray-800">
                            Rp {{ number_format($item->total_nota, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Terbayar -->
                    <div>
                        <span class="text-[11px] font-medium text-gray-400 block mb-0.5">Sudah Terbayar</span>
                        <span class="text-sm font-semibold text-emerald-600">
                            Rp {{ number_format($item->total_pelunasan, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Jatuh Tempo -->
                    <div>
                        <span class="text-[11px] font-medium text-gray-400 block mb-0.5">Jatuh Tempo</span>
                        <span class="text-xs font-semibold {{ $item->tanggal_tempo ? 'text-amber-600' : 'text-gray-500' }}">
                            {{ $item->tanggal_tempo ? date('d M Y', strtotime($item->tanggal_tempo)) : '-' }}
                        </span>
                    </div>

                    <!-- Sisa Piutang -->
                    <div class="col-span-2 sm:col-span-1 text-left sm:text-right pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                        <span class="text-[11px] font-medium text-gray-400 block mb-0.5">Sisa Tagihan</span>
                        <span class="text-base font-extrabold text-rose-600">
                            Rp {{ number_format($sisa, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

                <!-- PROGRESS BAR PELUNASAN -->
                <div class="space-y-1">
                    <div class="flex justify-between text-[11px] font-medium text-gray-400">
                        <span>Progres Pelunasan</span>
                        <span class="text-gray-600 font-bold">{{ $persenTerbayar }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-500 h-2 rounded-full transition-all duration-300" style="width: {{ $persenTerbayar }}%"></div>
                    </div>
                </div>

                <!-- FOOTER ACTION BUTTON -->
                <div class="flex justify-end pt-1">
                    <a href="/transaksi/{{ $item->jual_id }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                        <span>Lihat Rincian Nota</span>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>

            </div>
        @empty
            <!-- EMPTY STATE TOKOPEDIA -->
            <div class="bg-white rounded-2xl p-10 text-center border border-gray-200 shadow-sm space-y-3">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto text-2xl border border-emerald-100">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-base">Tidak Ada Sisa Tagihan</h3>
                    <p class="text-xs text-gray-400 mt-1">Semua kewajiban transaksi Anda saat ini sudah lunas.</p>
                </div>
                <div class="pt-2">
                    <a href="/transaksi" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition">
                        Lihat Riwayat Transaksi
                    </a>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection