@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        
        <!-- HEADER & TOMBOL KEMBALI -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-3xl shadow-sm mb-8 gap-4 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <span class="text-xs font-bold tracking-wider text-red-600 uppercase">Keamanan Akun</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Ganti PIN</h2>
                </div>
            </div>

            <!-- Tombol Kembali ke Dashboard -->
            <a href="/dashboard" class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition text-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- KARTU FORM GANTI PIN -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            
            <!-- Notifikasi Error Validasi Laravel -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-700 p-4 rounded-2xl mb-6 flex items-start gap-3 text-sm font-medium">
                    <i class="fa-solid fa-circle-exclamation text-red-600 text-lg mt-0.5"></i>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 rounded-2xl mb-6 flex items-center gap-3 text-sm font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Notifikasi Error Custom dari Session -->
            @if(session('error'))
                <div class="bg-red-50 border border-red-100 text-red-700 p-4 rounded-2xl mb-6 flex items-center gap-3 text-sm font-medium">
                    <i class="fa-solid fa-circle-exclamation text-red-600 text-lg"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="/change-pin" method="POST">
                @csrf
                
                <!-- PIN Lama -->
<div class="mb-5">
    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">PIN Lama</label>
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
            <i class="fa-solid fa-key text-sm"></i>
        </span>
        <input type="password" name="pin_lama" inputmode="numeric" pattern="[0-9]*" maxlength="6" placeholder="Masukkan PIN lama Anda" required
            class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl py-3 pl-11 pr-4 text-gray-900 text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition">
    </div>
</div>

<!-- PIN Baru -->
<div class="mb-5">
    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">PIN Baru</label>
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
            <i class="fa-solid fa-lock text-sm"></i>
        </span>
        <input type="password" name="pin_baru" inputmode="numeric" pattern="[0-9]*" maxlength="6" placeholder="Masukkan 6 digit PIN baru" required
            class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl py-3 pl-11 pr-4 text-gray-900 text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition">
    </div>
</div>

<!-- Konfirmasi PIN -->
<div class="mb-8">
    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Konfirmasi PIN Baru</label>
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
            <i class="fa-solid fa-shield-halved text-sm"></i>
        </span>
        <input type="password" name="konfirmasi_pin" inputmode="numeric" pattern="[0-9]*" maxlength="6" placeholder="Ulangi 6 digit PIN baru Anda" required
            class="w-full bg-gray-50/50 border border-gray-200 rounded-2xl py-3 pl-11 pr-4 text-gray-900 text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition">
    </div>
</div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-xl transition shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan PIN Baru
                </button>
            </form>
        </div>

    </div>
@endsection