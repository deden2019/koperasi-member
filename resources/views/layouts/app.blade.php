<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Member Koperasi' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome untuk ikon pendukung -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#F8F9FA] font-sans antialiased text-gray-800">

<div class="min-h-screen flex flex-col pb-20 md:pb-0">
    
    <!-- HEADER / NAVBAR -->
    <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            
            <!-- Logo / Judul -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg shadow-sm">
                    <i class="fa-solid fa-store"></i>
                </div>
                <h1 class="font-bold text-xl text-gray-900 tracking-tight">
                    Member <span class="text-emerald-600">Koperasi</span>
                </h1>
            </div>

            <!-- Bagian Kanan Header (User & Logout) -->
            @if(session('nama_customer'))
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-2.5 bg-gray-50 px-4 py-2 rounded-2xl border border-gray-100">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr(session('nama_customer'), 0, 1)) }}
                        </div>
                        <span class="font-medium text-sm text-gray-700">
                            {{ session('nama_customer') }}
                        </span>
                    </div>

                    <!-- Form Logout -->
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-semibold text-sm transition duration-200">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> 
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </header>

    <!-- KONTEN UTAMA (Ditambahkan pb-24 agar tidak tertutup bottom nav di HP) -->
    <main class="flex-grow max-w-7xl w-full mx-auto p-6 sm:p-10 pb-24">
        @yield('content')
    </main>

    <!-- FOOTER SEDERHANA -->
    <footer class="bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-400 hidden md:block">
        &copy; {{ date('Y') }} Member Koperasi. All rights reserved.
    </footer>

</div>

<!-- Bottom Navigation Mobile (Hanya tampil di layar HP/sm ke bawah) -->
<div class="fixed bottom-0 left-0 z-50 w-full bg-white border-t border-gray-200 md:hidden shadow-lg">
    <div class="grid h-16 grid-cols-3">
        
        <!-- Menu Dashboard -->
        <a href="/dashboard" class="flex flex-col items-center justify-center gap-1 text-xs font-medium transition {{ request()->is('dashboard') ? 'text-emerald-600 font-bold' : 'text-gray-500 hover:text-gray-900' }}">
            <i class="fa-solid fa-house text-lg"></i>
            <span>Dashboard</span>
        </a>

        <!-- Menu Transaksi -->
        <a href="/transaksi" class="flex flex-col items-center justify-center gap-1 text-xs font-medium transition {{ request()->is('transaksi*') ? 'text-emerald-600 font-bold' : 'text-gray-500 hover:text-gray-900' }}">
            <i class="fa-solid fa-file-invoice text-lg"></i>
            <span>Transaksi</span>
        </a>

        <!-- Menu Profil -->
        <a href="/profile" class="flex flex-col items-center justify-center gap-1 text-xs font-medium transition {{ request()->is('profile*') ? 'text-emerald-600 font-bold' : 'text-gray-500 hover:text-gray-900' }}">
            <i class="fa-solid fa-user text-lg"></i>
            <span>Profil</span>
        </a>

    </div>
</div>

</body>
</html>