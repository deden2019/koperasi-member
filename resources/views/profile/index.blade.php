@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        
        <!-- ALERT SUCCESS JIKA ADA NOTIFIKASI -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 shadow-sm text-sm">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <span class="font-bold block">Berhasil!</span>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- HEADER & TOMBOL KEMBALI -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-3xl shadow-sm mb-8 gap-4 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Informasi Akun</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Profil Anggota</h2>
                </div>
            </div>

            <!-- Tombol Aksi Cepat & Navigasi -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="/card" class="flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition text-sm shadow-lg shadow-emerald-600/20">
                    <i class="fa-solid fa-id-card"></i> Kartu Digital
                </a>
                <a href="/dashboard" class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- KARTU KONTEN PROFIL -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-emerald-600"></i> Data Utama Anggota
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Kode Anggota -->
                <div class="p-5 rounded-2xl bg-gray-50/50 border border-gray-100 flex flex-col justify-between">
                    <span class="text-xs font-medium text-gray-400 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-id-card text-emerald-600"></i> Kode Anggota
                    </span>
                    <span class="font-bold text-lg text-gray-900 tracking-wide">{{ $customer->kode_customer }}</span>
                </div>

                <!-- Nama -->
                <div class="p-5 rounded-2xl bg-gray-50/50 border border-gray-100 flex flex-col justify-between">
                    <span class="text-xs font-medium text-gray-400 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-user-tag text-emerald-600"></i> Nama Lengkap
                    </span>
                    <span class="font-bold text-lg text-gray-900">{{ $customer->nama_customer }}</span>
                </div>

                <!-- Telepon -->
                <div class="p-5 rounded-2xl bg-gray-50/50 border border-gray-100 flex flex-col justify-between">
                    <span class="text-xs font-medium text-gray-400 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-phone text-emerald-600"></i> Nomor Telepon
                    </span>
                    <span class="font-bold text-lg text-gray-900">{{ $customer->telepon }}</span>
                </div>

                <!-- Status Member -->
                <div class="p-5 rounded-2xl bg-gray-50/50 border border-gray-100 flex flex-col justify-between">
                    <span class="text-xs font-medium text-gray-400 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-emerald-600"></i> Status Anggota
                    </span>
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold border border-emerald-100">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                        </span>
                    </div>
                </div>

                <!-- Login Terakhir -->
                <div class="p-5 rounded-2xl bg-gray-50/50 border border-gray-100 flex flex-col justify-between">
                    <span class="text-xs font-medium text-gray-400 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-clock text-emerald-600"></i> Login Terakhir
                    </span>
                    <span class="font-bold text-base text-gray-900">
                        {{ isset($customer->last_login) ? date('d-m-Y H:i', strtotime($customer->last_login)) : '-' }}
                    </span>
                </div>

                <!-- Alamat -->
                <div class="p-5 rounded-2xl bg-gray-50/50 border border-gray-100 flex flex-col justify-between md:col-span-2">
                    <span class="text-xs font-medium text-gray-400 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-emerald-600"></i> Alamat Lengkap
                    </span>
                    <span class="font-bold text-base text-gray-900">{{ $customer->alamat }}</span>
                </div>

            </div>

            <!-- INFORMASI WILAYAH (Opsional jika datanya ada) -->
            @if(isset($customer->provinsi) || isset($customer->kabupaten) || isset($customer->kecamatan) || isset($customer->kelurahan))
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-emerald-600"></i> Wilayah Domisili
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                            <span class="text-xs text-gray-400 block mb-1">Provinsi</span>
                            <span class="font-semibold text-gray-900 text-sm">{{ $customer->provinsi ?? '-' }}</span>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                            <span class="text-xs text-gray-400 block mb-1">Kabupaten/Kota</span>
                            <span class="font-semibold text-gray-900 text-sm">{{ $customer->kabupaten ?? '-' }}</span>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                            <span class="text-xs text-gray-400 block mb-1">Kecamatan</span>
                            <span class="font-semibold text-gray-900 text-sm">{{ $customer->kecamatan ?? '-' }}</span>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                            <span class="text-xs text-gray-400 block mb-1">Kelurahan</span>
                            <span class="font-semibold text-gray-900 text-sm">{{ $customer->kelurahan ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- TOMBOL EDIT PROFIL -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                <div class="flex gap-3">
                    <a href="/profile/edit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-3 rounded-xl flex items-center gap-2 transition text-sm shadow-md shadow-emerald-600/20">
                        <i class="fa-solid fa-pen"></i> Edit Profil
                    </a>
                </div>
            </div>

        </div>

    </div>
@endsection