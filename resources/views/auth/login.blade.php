<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Member Koperasi</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="flex w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden">
            
            <!-- KOLOM KIRI: Gambar & Testimoni/Banner (Mirip Referensi) -->
            <div class="hidden lg:block lg:w-1/2 relative bg-cover bg-center p-12 flex flex-col justify-end" style="background-image: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=1000');">
                <!-- Overlay Gelap agar teks terbaca -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                
                <!-- Kotak Testimoni / Info Singkat di Bawah Gambar -->
                <div class="relative z-10 bg-black/40 backdrop-blur-md p-6 rounded-2xl text-white border border-white/10">
                    <p class="text-sm italic mb-4">
                        "Layanan digital koperasi yang cepat, transparan, dan sangat memudahkan anggota dalam mengelola simpanan serta pembiayaan secara mandiri."
                    </p>
                    <div class="flex items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" alt="User" class="w-10 h-10 rounded-full object-cover border border-white/20">
                        <div>
                            <h4 class="text-sm font-semibold">Siti Aminah</h4>
                            <p class="text-xs text-gray-300">Anggota Koperasi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Form Login -->
            <div class="w-full lg:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
                
                <!-- Header Teks -->
                <div class="mb-8">
                    <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">KOPERASI MEMBER</span>
                    <h2 class="text-3xl font-bold text-gray-900 mt-1">Selamat Datang Kembali</h2>
                    <p class="text-sm text-gray-500 mt-1">Silakan masuk menggunakan Nomor HP dan PIN Anda.</p>
                </div>

                <!-- Notifikasi Error (Jika Gagal Login) -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Form Login -->
                <form action="/login" method="POST" class="space-y-5">
                    @csrf

                    <!-- Input Nomor HP / Telepon -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                        <input 
                            type="text" 
                            name="telepon" 
                            placeholder="Contoh: 081234567890" 
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                        >
                    </div>

                    <!-- Input PIN -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-semibold text-gray-700">PIN</label>
                            <a href="#" class="text-xs text-emerald-600 hover:underline font-medium">Lupa PIN?</a>
                        </div>
                        <input 
                            type="password" 
                            name="pin" 
                            placeholder="Masukkan PIN Anda" 
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                        >
                    </div>

                    <!-- Tombol Login -->
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg shadow-emerald-600/20 transition duration-200 text-sm"
                    >
                        Login
                    </button>
                </form>

                <!-- Footer / Terms -->
                <p class="text-xs text-center text-gray-400 mt-8">
                    Dengan masuk, Anda menyetujui <a href="#" class="underline hover:text-gray-600">Syarat & Ketentuan</a> yang berlaku.
                </p>

            </div>

        </div>
    </div>

</body>
</html>