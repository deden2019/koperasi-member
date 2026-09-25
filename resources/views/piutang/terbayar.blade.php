@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- HEADER / JUDUL HALAMAN -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <span class="text-xs font-bold tracking-wider text-teal-600 uppercase">Riwayat Bayar</span>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Riwayat Pembayaran Piutang</h2>
            </div>
        </div>
        <a href="/dashboard" class="text-sm font-medium text-gray-500 bg-gray-50 hover:bg-gray-100 px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- DAFTAR RIWAYAT PEMBAYARAN -->
    <div class="space-y-4">
        @forelse($pembayaran as $item)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                
                <!-- Grid 5 Kolom -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 items-center">
                    
                    <!-- 1. Nota Pembayaran -->
                    <div>
                        <div class="text-xs font-medium text-gray-400 block mb-1">Nota Pembayaran</div>
                        <div class="font-bold text-gray-900 tracking-wide">
                            {{ $item->nota_bayar ?? '-' }}
                        </div>
                    </div>

                    <!-- 2. Nota Jual (Bisa diklik jika ada jual_id) -->
                    <div>
                        <div class="text-xs font-medium text-gray-400 block mb-1">Nota Jual</div>
                        @if(isset($item->jual_id))
                            <a href="/transaksi/{{ $item->jual_id }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline tracking-wide inline-flex items-center gap-1">
                                {{ $item->nota_jual }}
                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                            </a>
                        @else
                            <div class="font-bold text-gray-900 tracking-wide">
                                {{ $item->nota_jual }}
                            </div>
                        @endif
                    </div>

                    <!-- 3. Tanggal Bayar -->
                    <div>
                        <div class="text-xs font-medium text-gray-400 block mb-1">Tanggal Bayar</div>
                        <div class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-gray-400"></i>
                            {{ date('d-m-Y', strtotime($item->tanggal_bayar)) }}
                        </div>
                    </div>

                    <!-- 4. Metode / Keterangan -->
                    <div>
                        <div class="text-xs font-medium text-gray-400 block mb-1">Metode</div>
                        <div>
                            @if(!empty($item->keterangan))
                                <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-medium inline-block">
                                    {{ $item->keterangan }}
                                </span>
                            @else
                                <span class="bg-gray-50 text-gray-600 px-3 py-1 rounded-full text-xs font-medium inline-block">
                                    Pembayaran Piutang
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- 5. Nominal -->
                    <div class="col-span-2 sm:col-span-1 lg:text-right pt-2 lg:pt-0 border-t lg:border-t-0 border-gray-100 flex lg:flex-col justify-between items-center lg:items-end">
                        <div class="text-xs font-medium text-gray-400 block mb-1">Nominal</div>
                        <div class="font-extrabold text-emerald-600 text-base">
                            Rp {{ number_format($item->nominal,0,',','.') }}
                        </div>
                    </div>

                </div>

            </div>
        @empty
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-3xl flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">Belum Ada Riwayat Pembayaran</h3>
                <p class="text-sm text-gray-400">Belum ada catatan pembayaran piutang yang tercatat di akun Anda.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection