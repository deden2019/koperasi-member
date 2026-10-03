@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <!-- BREADCRUMB NAVIGASI -->
    <nav class="flex text-xs text-gray-500 mb-4 gap-2">
        <a href="/dashboard" class="hover:text-emerald-600">Home</a>
        <span>/</span>
        <a href="/profile" class="hover:text-emerald-600">Profil Saya</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold">Ubah Profil</span>
    </nav>

    <!-- KARTU UTAMA EDIT PROFIL -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        
        <!-- HEADER KARTU -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <div>
                <h1 class="text-lg font-bold text-gray-900">Ubah Profil</h1>
                <p class="text-xs text-gray-500">Kelola informasi profil Anda untuk mengamankan akun</p>
            </div>
            <a href="/profile" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Profil
            </a>
        </div>

        <div class="p-6">
            
            <!-- ALERT VALIDASI ERROR TOKOPEDIA STYLE -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-lg mt-0.5 flex-shrink-0"></i>
                    <div>
                        <span class="font-bold block mb-1">Gagal Menyimpan Perubahan:</span>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="/profile/update" method="POST" enctype="multipart/form- Guessing form data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- SISI KIRI: FOTO PROFIL / AVATAR -->
                    <div class="md:col-span-1 flex flex-col items-center justify-start border-b md:border-b-0 md:border-r border-gray-100 pb-6 md:pb-0 md:pr-6">
                        <div class="relative w-32 h-32 mb-4">
                            <div class="w-32 h-32 rounded-full bg-emerald-100 border-2 border-emerald-500 flex items-center justify-center text-emerald-700 text-5xl font-bold uppercase shadow-inner">
                                {{ substr($customer->nama_customer, 0, 1) }}
                            </div>
                        </div>

                        <div class="w-full text-center">
                            <label class="cursor-pointer block w-full py-2 px-3 border border-gray-300 hover:border-emerald-600 hover:text-emerald-600 text-gray-700 font-semibold text-xs rounded-xl transition bg-white shadow-sm mb-2">
                                <i class="fa-solid fa-camera mr-1"></i> Pilih Foto
                                <input type="file" name="foto" class="hidden" accept="image/*">
                            </label>
                            <p class="text-[11px] text-gray-400 leading-tight">
                                Besar file: maks. 2MB<br>Ekstensi yang diperbolehkan: .JPG .JPEG .PNG
                            </p>
                        </div>
                    </div>

                    <!-- SISI KANAN: FORM ISIAN DATA -->
                    <div class="md:col-span-2 space-y-5">
                        
                        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-2">
                            Ubah Biodata Diri
                        </h2>

                        <!-- KODE ANGGOTA (READONLY) -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                Kode Anggota
                            </label>
                            <input 
                                type="text" 
                                value="{{ $customer->kode_customer }}" 
                                disabled
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-gray-500 text-sm font-mono cursor-not-allowed">
                            <span class="text-[11px] text-gray-400 mt-0.5 block">Kode anggota tidak dapat diubah.</span>
                        </div>

                        <!-- NAMA LENGKAP (READONLY ATAU EDITABLE SESUAI KEBUTUHAN) -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                Nama Lengkap
                            </label>
                            <input 
                                type="text" 
                                value="{{ $customer->nama_customer }}" 
                                disabled
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-gray-500 text-sm font-semibold cursor-not-allowed">
                        </div>

                        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-2 pt-3">
                            Ubah Kontak & Alamat
                        </h2>

                        <!-- NOMOR TELEPON -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                Nomor Telepon / HP <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-xs">
                                    <i class="fa-solid fa-phone"></i>
                                </span>
                                <input 
                                    type="text" 
                                    inputmode="tel"
                                    name="telepon" 
                                    value="{{ old('telepon', $customer->telepon) }}" 
                                    class="w-full pl-9 pr-3 py-2.5 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-gray-900 text-sm transition"
                                    placeholder="Contoh: 081234567890"
                                    required>
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                Email <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-xs">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email', $customer->email ?? '') }}" 
                                    class="w-full pl-9 pr-3 py-2.5 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-gray-900 text-sm transition"
                                    placeholder="nama@email.com">
                            </div>
                        </div>

                        <!-- ALAMAT LENGKAP -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                Alamat Domisili <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="alamat" 
                                rows="3" 
                                class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-gray-900 text-sm transition"
                                placeholder="Masukkan alamat lengkap rumah / jalan / RT RW..."
                                required>{{ old('alamat', $customer->alamat) }}</textarea>
                        </div>

                        <!-- TOMBOL ACTION (SIMPAN & BATAL) -->
                        <div class="pt-4 flex items-center gap-3">
                            <button 
                                type="submit" 
                                class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition shadow-sm flex items-center gap-2">
                                <i class="fa-solid fa-check"></i> Simpan
                            </button>
                            <a 
                                href="/profile" 
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-xl text-sm transition flex items-center gap-2">
                                Batal
                            </a>
                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection