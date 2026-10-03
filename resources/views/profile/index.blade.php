@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    <!-- ALERT SUCCESS (Notification Tokopedia Style) -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm text-sm">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <div>
                    <span class="font-bold">Berhasil!</span> {{ session('success') }}
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- BREADCRUMB & HEADER -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <nav class="flex text-xs text-gray-500 mb-1 gap-2">
                <a href="/dashboard" class="hover:text-emerald-600">Home</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Profil Saya</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Profil</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="/card" class="flex items-center gap-2 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold rounded-lg text-sm transition border border-emerald-200">
                <i class="fa-solid fa-id-card"></i> Kartu Digital
            </a>
            <a href="/dashboard" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg text-sm transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- MAIN CONTAINER (LAYOUT 2 KOLOM TOKOPEDIA) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- KOLOM KIRI: AVATAR & AKSI CEPAT -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm text-center sticky top-6">
                <!-- Foto Profil / Avatar -->
                <div class="relative w-28 h-28 mx-auto mb-4">
                    <div class="w-28 h-28 rounded-full bg-emerald-100 border-2 border-emerald-500 flex items-center justify-center text-emerald-700 text-4xl font-bold uppercase shadow-inner">
                        {{ substr($customer->nama_customer, 0, 1) }}
                    </div>
                    <span class="absolute bottom-1 right-1 w-6 h-6 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center text-white text-xs" title="Anggota Aktif">
                        <i class="fa-solid fa-check"></i>
                    </span>
                </div>

                <h2 class="text-lg font-bold text-gray-900 mb-1">{{ $customer->nama_customer }}</h2>
                <p class="text-xs text-gray-500 font-mono mb-3">ID: {{ $customer->kode_customer }}</p>

                <!-- Status Badge -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold border border-emerald-200 mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Anggota Aktif
                </div>

                <hr class="border-gray-100 mb-6">

                <!-- Tombol Edit Profil -->
                <a href="/profile/edit" class="w-full block bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition shadow-sm mb-3">
                    <i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit Profil
                </a>

                <!-- Info Tambahan -->
                <div class="text-left text-xs text-gray-500 space-y-2 mt-4 pt-4 border-t border-gray-100">
                    <div class="flex justify-between">
                        <span>Terakhir Login:</span>
                        <span class="font-medium text-gray-700">
                            {{ isset($customer->last_login) ? date('d M Y H:i', strtotime($customer->last_login)) : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: DETAIL DATA ANGGOTA -->
        <div class="lg:col-span-2 space-y-6">

            <!-- CARD 1: BIODATA DIRI -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-user text-emerald-600"></i> Biodata Diri
                    </h3>
                </div>

                <div class="space-y-4 text-sm">
                    <!-- Nama -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 items-center">
                        <span class="text-gray-500">Nama Lengkap</span>
                        <span class="sm:col-span-2 font-semibold text-gray-900">{{ $customer->nama_customer }}</span>
                    </div>

                    <!-- Kode Customer -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 items-center">
                        <span class="text-gray-500">Kode Anggota</span>
                        <span class="sm:col-span-2 font-semibold text-gray-900 font-mono">{{ $customer->kode_customer }}</span>
                    </div>

                    <!-- Status Anggota -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 items-center">
                        <span class="text-gray-500">Status Keanggotaan</span>
                        <span class="sm:col-span-2">
                            <span class="text-emerald-600 font-semibold bg-emerald-50 px-2.5 py-0.5 rounded text-xs border border-emerald-100">Verified Member</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- CARD 2: KONTAK & ALAMAT -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-address-card text-emerald-600"></i> Kontak & Alamat
                    </h3>
                </div>

                <div class="space-y-4 text-sm">
                    <!-- Nomor Telepon -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 items-start">
                        <span class="text-gray-500 pt-0.5">Nomor Telepon / WA</span>
                        <div class="sm:col-span-2 flex items-center gap-2">
                            <span class="font-semibold text-gray-900">{{ $customer->telepon ?? '-' }}</span>
                            @if(!empty($customer->telepon))
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">Terverifikasi</span>
                            @endif
                        </div>
                    </div>

                    <!-- Alamat Utama -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 items-start">
                        <span class="text-gray-500">Alamat Lengkap</span>
                        <span class="sm:col-span-2 font-medium text-gray-800 leading-relaxed">{{ $customer->alamat ?? '-' }}</span>
                    </div>
                </div>

                <!-- SUB-SECTION: WILAYAH DOMISILI -->
                @if(isset($customer->provinsi) || isset($customer->kabupaten) || isset($customer->kecamatan) || isset($customer->kelurahan))
                    <div class="mt-6 pt-5 border-t border-gray-100">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Detail Wilayah Domisili</h4>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <span class="text-[11px] text-gray-400 block mb-0.5">Provinsi</span>
                                <span class="font-semibold text-gray-800 text-xs truncate block">{{ $customer->provinsi ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <span class="text-[11px] text-gray-400 block mb-0.5">Kabupaten/Kota</span>
                                <span class="font-semibold text-gray-800 text-xs truncate block">{{ $customer->kabupaten ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <span class="text-[11px] text-gray-400 block mb-0.5">Kecamatan</span>
                                <span class="font-semibold text-gray-800 text-xs truncate block">{{ $customer->kecamatan ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <span class="text-[11px] text-gray-400 block mb-0.5">Kelurahan</span>
                                <span class="font-semibold text-gray-800 text-xs truncate block">{{ $customer->kelurahan ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection