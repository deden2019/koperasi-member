@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        
        <!-- Header Judul -->
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Pengaturan Akun</span>
                <h2 class="text-2xl font-bold text-gray-900">Edit Profil</h2>
            </div>
        </div>

        <!-- Validasi Error -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl text-sm">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i> Terdapat kesalahan pengisian:
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Edit Profil -->
        <form action="/profile/update" method="POST">
            @csrf
            
            <!-- Nomor Telepon -->
            <div class="mb-5">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Nomor Telepon
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="fa-solid fa-phone text-sm"></i>
                    </span>
                    <input 
                        type="text" 
                        inputmode="tel"
                        name="telepon" 
                        value="{{ old('telepon', $customer->telepon) }}" 
                        class="w-full pl-11 pr-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-gray-900 text-sm transition"
                        placeholder="Masukkan nomor telepon aktif">
                </div>
            </div>

            <!-- Email (Opsional) -->
            <div class="mb-5">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Email
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="fa-solid fa-envelope text-sm"></i>
                    </span>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $customer->email ?? '') }}" 
                        class="w-full pl-11 pr-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-gray-900 text-sm transition"
                        placeholder="alamat.email@domain.com">
                </div>
            </div>

            <!-- Alamat -->
            <div class="mb-8">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Alamat Lengkap
                </label>
                <textarea 
                    name="alamat" 
                    rows="4" 
                    class="w-full p-4 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-gray-900 text-sm transition"
                    placeholder="Masukkan alamat domisili lengkap...">{{ old('alamat', $customer->alamat) }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button 
                    type="submit" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-xl transition text-sm shadow-lg shadow-emerald-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a 
                    href="/profile" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-xl transition text-sm flex items-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
            </div>

        </form>

    </div>

</div>
@endsection