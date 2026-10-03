<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kopkar RSPB' }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tokopedia: {
                            DEFAULT: '#00AA5B',
                            hover: '#039651',
                            light: '#E8F5E9',
                            dark: '#008A49'
                        }
                    }
                }
            }
        }
    </script>

    <!-- 1. PWA Manifest & Theme Color -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#00AA5B">

    <!-- 2. Apple / iOS Support -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Kopkar RSPB">

    <!-- 3. Favicon & Icon Apple/Android -->
    <link rel="icon" type="image/png" href="{{ asset('images/koperasi.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/koperasi.png') }}">

    <!-- 4. Swiper CSS (Hanya jika Anda menggunakan Jumbotron Slide Show) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- 5. FontAwesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- 6. Script Registrasi Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(function(reg) {
                        console.log('Service Worker Registered!', reg);
                    })
                    .catch(function(err) {
                        console.error('Service Worker Registration Failed!', err);
                    });
            });
        }
    </script>
</head>
<body class="bg-[#F3F4F6] font-sans antialiased text-gray-800">

<div class="min-h-screen flex flex-col pb-20 md:pb-0">
    
    <!-- HEADER / NAVBAR STYLE TOKOPEDIA -->
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <!-- Top Bar Desktop -->
        <div class="hidden md:block bg-gray-100 border-b border-gray-200 text-xs text-gray-500 py-1">
            <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
                <div class="flex gap-4">
                    <span><i class="fa-solid fa-mobile-screen mr-1"></i> Download Aplikasi Kopkar</span>
                    <span>Tentang Kopkar RSPB</span>
                </div>
                <div class="flex gap-4">
                    <span>Promo</span>
                    <span>Bantuan</span>
                </div>
            </div>
        </div>

        <!-- Main Navbar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-2.5 flex items-center justify-between gap-4">
            
            <!-- Logo / Judul -->
            <a href="/dashboard" class="flex items-center gap-2.5 shrink-0">
                <div class="w-9 h-9 rounded-lg overflow-hidden flex items-center justify-center bg-white border border-gray-100 shadow-sm">
                    <img src="{{ asset('images/koperasi.png') }}" alt="Logo Koperasi" class="w-full h-full object-cover">
                </div>
                <h1 class="font-bold text-lg text-gray-800 tracking-tight hidden sm:block">
                    Kopkar <span class="text-tokopedia">RSPB</span>
                </h1>
            </a>

            <!-- Search Bar khas Tokopedia -->
            <div class="flex-1 max-w-2xl relative">
                <div class="relative flex items-center">
                    <input type="text" placeholder="Cari layanan, simpanan, atau produk..." 
                           class="w-full pl-10 pr-4 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-tokopedia focus:ring-1 focus:ring-tokopedia transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-gray-400 text-sm"></i>
                </div>
            </div>

            <!-- User Menu & Action Icons -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- Icon Notifikasi / Keranjang -->
                <button onclick="requestNotificationPermission()" type="button" class="relative p-2 text-gray-600 hover:text-emerald-600 focus:outline-none" title="Aktifkan Notifikasi">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <!-- Dot merah status -->
                    <span id="notif-dot" class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                @if(session('nama_customer'))
                    <div class="h-6 w-[1px] bg-gray-200 hidden sm:block"></div>

                    <!-- User Info -->
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-tokopedia-light text-tokopedia flex items-center justify-center text-xs font-bold border border-tokopedia/20">
                            {{ strtoupper(substr(session('nama_customer'), 0, 1)) }}
                        </div>
                        <span class="font-semibold text-xs text-gray-700 max-w-[100px] truncate">
                            {{ session('nama_customer') }}
                        </span>
                    </div>

                    <!-- Logout Button -->
                    <form action="/logout" method="POST" class="m-0">
                        @csrf
                        <button type="submit" title="Logout" class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 font-semibold text-xs transition">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 py-6 pb-24">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-500 hidden md:block mt-auto">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <p>&copy; {{ date('Y') }} Kopkar RSPB. Hak Cipta Dilindungi.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-tokopedia">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-tokopedia">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</div>

<!-- BOTTOM NAVIGATION MOBILE (Gaya Tokopedia App) -->
<div class="fixed bottom-0 left-0 z-50 w-full bg-white border-t border-gray-200 md:hidden shadow-lg">
    <div class="grid h-14 grid-cols-3">
        
        <!-- Dashboard -->
        <a href="/dashboard" class="flex flex-col items-center justify-center gap-0.5 text-[10px] font-medium transition {{ request()->is('dashboard') ? 'text-tokopedia font-bold' : 'text-gray-500 hover:text-gray-900' }}">
            <i class="fa-solid fa-house text-base"></i>
            <span>Beranda</span>
        </a>

        <!-- Transaksi -->
        <a href="/transaksi" class="flex flex-col items-center justify-center gap-0.5 text-[10px] font-medium transition {{ request()->is('transaksi*') ? 'text-tokopedia font-bold' : 'text-gray-500 hover:text-gray-900' }}">
            <i class="fa-solid fa-receipt text-base"></i>
            <span>Transaksi</span>
        </a>

        <!-- Profil -->
        <a href="/profile" class="flex flex-col items-center justify-center gap-0.5 text-[10px] font-medium transition {{ request()->is('profile*') ? 'text-tokopedia font-bold' : 'text-gray-500 hover:text-gray-900' }}">
            <i class="fa-solid fa-user text-base"></i>
            <span>Profil</span>
        </a>

    </div>
</div>

<script>
    function requestNotificationPermission() {
        if (!('Notification' in window)) {
            alert('Browser ini tidak mendukung notifikasi.');
            return;
        }

        Notification.requestPermission().then(function (permission) {
            if (permission === 'granted') {
                alert('Notifikasi berhasil diaktifkan!');
                // Sembunyikan dot merah jika izin sudah diberikan
                const dot = document.getElementById('notif-dot');
                if(dot) dot.classList.add('hidden');
                
                // Coba tes tampilkan notifikasi lokal
                if (navigator.serviceWorker && navigator.serviceWorker.controller) {
                    navigator.serviceWorker.ready.then(function(reg) {
                        reg.showNotification("Kopkar RSPB", {
                            body: "Notifikasi aplikasi berhasil diaktifkan!",
                            icon: "/images/koperasi.png"
                        });
                    });
                }
            } else if (permission === 'denied') {
                alert('Izin notifikasi ditolak. Anda bisa mengizinkannya via Pengaturan Browser.');
            }
        });
    }

    // Cek status saat halaman pertama kali dibuka
    document.addEventListener("DOMContentLoaded", function() {
        if ('Notification' in window && Notification.permission === 'granted') {
            const dot = document.getElementById('notif-dot');
            if(dot) dot.classList.add('hidden');
        }
    });
</script>


<!-- ==================== MODAL AJAKAN INSTALL PWA ==================== -->
<div id="pwa-install-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-end sm:items-center justify-center p-0 sm:p-4 transition-opacity duration-300">
    <div class="bg-white w-full max-w-md rounded-t-3xl sm:rounded-3xl p-6 shadow-2xl space-y-5 animate-slide-up">
        
        <!-- Header Modal & Icon -->
        <div class="text-center space-y-3">
            <div class="w-16 h-16 bg-emerald-50 rounded-2xl mx-auto flex items-center justify-center p-2 border border-emerald-100 shadow-sm">
                <img src="{{ asset('images/koperasi.png') }}" alt="Logo Koperasi" class="w-full h-full object-contain">
            </div>
            <div>
                <h3 class="text-lg font-extrabold text-gray-900">Install Aplikasi Kopkar RSPB</h3>
                <p class="text-xs text-gray-500 mt-1">Dapatkan akses lebih cepat dan notifikasi transaksi langsung di HP Anda!</p>
            </div>
        </div>

        <!-- Keuntungan Install -->
        <div class="bg-gray-50 rounded-2xl p-3.5 space-y-2 border border-gray-100">
            <div class="flex items-center gap-3 text-xs text-gray-700">
                <i class="fa-solid fa-bell text-tokopedia text-sm"></i>
                <span>Notifikasi tagihan & transaksi di layar HP</span>
            </div>
            <div class="flex items-center gap-3 text-xs text-gray-700">
                <i class="fa-solid fa-bolt text-tokopedia text-sm"></i>
                <span>Akses kilat dari Home Screen tanpa ketik URL</span>
            </div>
            <div class="flex items-center gap-3 text-xs text-gray-700">
                <i class="fa-solid fa-shield-halved text-tokopedia text-sm"></i>
                <span>Aman, ringan, dan tidak memenuhi memori HP</span>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="space-y-2 pt-1">
            <button id="btn-install-pwa" onclick="installPWA()" class="w-full bg-tokopedia hover:bg-tokopedia-hover text-white font-bold py-3 px-4 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
                <i class="fa-solid fa-download"></i> Install Aplikasi Sekarang
            </button>
            <button onclick="closeInstallModal()" class="w-full bg-transparent hover:bg-gray-100 text-gray-500 font-semibold py-2 px-4 rounded-xl text-xs transition">
                Nanti Saja
            </button>
        </div>

    </div>
</div>

<!-- ==================== SCRIPT KONTROL LOGIKA PWA ==================== -->
<script>
    let deferredPrompt;

    // Fungsi untuk mengecek apakah aplikasi dibuka dalam mode PWA (Standalone/Installed)
    function isPWAInstalled() {
        return window.matchMedia('(display-mode: standalone)').matches || 
               window.navigator.standalone === true;
    }

    // Fungsi untuk mengecek apakah modal sudah pernah muncul hari ini
    function isShownToday() {
        const lastShownDate = localStorage.getItem('pwa_modal_last_shown');
        const today = new Date().toDateString(); // Mengambil format tanggal "Sat Oct 03 2026"
        return lastShownDate === today;
    }

    // 1. Tangkap Event PWA dari Browser
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;

        // JIKA sudah di-install PWA -> JANGAN TAMPILKAN
        if (isPWAInstalled()) {
            return;
        }

        // JIKA diakses dari browser tapi SUDAH TAMPIL HARI INI -> JANGAN TAMPILKAN
        if (isShownToday()) {
            return;
        }

        // Tampilkan modal jika di browser biasa & belum pernah muncul hari ini
        setTimeout(() => {
            showInstallModal();
        }, 1000);
    });

    function showInstallModal() {
        const modal = document.getElementById('pwa-install-modal');
        if (modal) {
            modal.classList.remove('hidden');
            // Simpan tanggal hari ini agar tidak muncul lagi di hari yang sama
            const today = new Date().toDateString();
            localStorage.setItem('pwa_modal_last_shown', today);
        }
    }

    function closeInstallModal() {
        const modal = document.getElementById('pwa-install-modal');
        if (modal) modal.classList.add('hidden');
    }

    // 2. Fungsi Tombol "Install Aplikasi Sekarang"
    function installPWA() {
        if (deferredPrompt) {
            deferredPrompt.prompt();

            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    if ('Notification' in window) {
                        Notification.requestPermission();
                    }
                }
                deferredPrompt = null;
                closeInstallModal();
            });
        } else {
            alert('Untuk menginstall di iPhone/Safari:\n1. Tekan tombol Share (Kotak Panah Atas)\n2. Pilih "Add to Home Screen" / "Tambahkan ke Layar Utama"');
            closeInstallModal();
        }
    }

    // Sembunyikan otomatis jika berhasil di-install
    window.addEventListener('appinstalled', () => {
        closeInstallModal();
    });
</script>

</body>
</html>