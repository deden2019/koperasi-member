<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopkar RSPB - Koperasi Karyawan RSPB</title>
    <link rel="icon" type="image/png" href="{{ asset('images/koperasi.png') }}?v=1">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .swiper-pagination-bullet-active {
            background-color: #059669 !important;
            width: 24px !important;
            border-radius: 9999px !important;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Header / Navbar -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-brand-50 rounded-xl border border-brand-100/50">
                    <img src="{{ asset('images/koperasi.png') }}" alt="Logo Koperasi" class="h-9 w-auto object-contain">
                </div>
                <div>
                    <span class="font-extrabold text-xl text-slate-900 tracking-tight block leading-none">KOPKAR <span class="text-brand-600">RSPB</span></span>
                    <span class="text-[10px] font-semibold text-slate-400 tracking-widest uppercase">Portal Anggota</span>
                </div>
            </div>
            <div>
                <a href="{{ url('/login') }}" class="group inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-md shadow-brand-600/20 hover:shadow-lg hover:shadow-brand-600/30">
                    <span>Portal Member</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-brand-900 via-brand-800 to-slate-900 text-white pt-20 pb-28 overflow-hidden">
        <!-- Accent Glow Effects -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-brand-200 text-xs font-medium mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                    Layanan Resmi Koperasi Karyawan RSPB
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.15] mb-6">
                    Solusi Keuangan Digital <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-teal-200 to-white">Anggota Koperasi</span>
                </h1>
                <p class="text-base sm:text-lg text-slate-300 mb-8 font-normal leading-relaxed max-w-2xl">
                    Pantau simpanan, cek riwayat piutang, dan lakukan transaksi dengan praktis, aman, serta transparan dalam satu sistem terpadu.
                </p>
                <div class="flex flex-wrap gap-4 items-center">
                    <a href="{{ url('/login') }}" class="bg-white text-brand-900 hover:bg-brand-50 px-7 py-3.5 rounded-xl font-bold text-sm shadow-xl shadow-black/10 transition-all hover:scale-[1.02] active:scale-[0.98]">
                        Masuk ke Akun Saya
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Slider Promo / Flyer Carousel -->
    <section class="-mt-14 relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="bg-white p-4 sm:p-6 rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100">
            <div class="flex items-center justify-between mb-5 px-2">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Informasi & Promo Terkini</h2>
                    <p class="text-slate-500 text-xs mt-0.5">Pengumuman penting dan penawaran khusus anggota</p>
                </div>
            </div>

            <!-- Swiper Slider Container -->
            <div class="swiper promoSwiper rounded-2xl overflow-hidden">
                <div class="swiper-wrapper">
                    
                    <!-- Slide 1: Banner Flyer 1 -->
                    <div class="swiper-slide">
                        <div class="relative w-full h-64 sm:h-80 md:h-[360px] bg-gradient-to-r from-brand-800 to-emerald-600 flex items-center p-8 sm:p-12 text-white overflow-hidden">
                            <div class="absolute right-0 top-0 bottom-0 w-1/2 opacity-15 pointer-events-none flex items-center justify-center">
                                <img src="{{ asset('images/koperasi.png') }}" alt="Watermark" class="h-96 object-contain">
                            </div>
                            <div class="relative z-10 max-w-xl">
                                <span class="bg-amber-400 text-slate-950 text-[11px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider mb-4 inline-block shadow-sm">
                                    Promo Spesial
                                </span>
                                <h3 class="text-2xl sm:text-3xl font-extrabold mb-3 leading-snug">
                                    Pembiayaan Syariah Anggota Koperasi
                                </h3>
                                <p class="text-sm text-emerald-100 mb-6 font-normal leading-relaxed">
                                    Proses mudah, margin kompetitif, dan pencairan cepat khusus untuk anggota Koperasi Karyawan RSPB.
                                </p>
                                <a href="{{ url('/login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-white bg-white/20 hover:bg-white/30 backdrop-blur-md border border-white/20 px-4 py-2.5 rounded-lg transition">
                                    Pelajari Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Banner Flyer 2 -->
                    <div class="swiper-slide">
                        <div class="relative w-full h-64 sm:h-80 md:h-[360px] bg-gradient-to-r from-teal-800 to-slate-800 flex items-center p-8 sm:p-12 text-white overflow-hidden">
                            <div class="relative z-10 max-w-xl">
                                <span class="bg-teal-400 text-teal-950 text-[11px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider mb-4 inline-block shadow-sm">
                                    Pengumuman
                                </span>
                                <h3 class="text-2xl sm:text-3xl font-extrabold mb-3 leading-snug">
                                    Persiapan Rapat Anggota Tahunan (RAT)
                                </h3>
                                <p class="text-sm text-teal-100 mb-6 font-normal leading-relaxed">
                                    Pastikan data keanggotaan dan simpanan Anda sudah terbarukan untuk perhitungan SHU tahun buku ini.
                                </p>
                                <a href="{{ url('/login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-white bg-white/20 hover:bg-white/30 backdrop-blur-md border border-white/20 px-4 py-2.5 rounded-lg transition">
                                    Cek Status Anggota
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Swiper Navigation & Pagination -->
                <div class="swiper-pagination !bottom-4"></div>
            </div>
        </div>
    </section>

    <!-- Fitur & Layanan Utama -->
    <section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-brand-600 font-bold text-xs uppercase tracking-widest block mb-2">Layanan Digital</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kemudahan Akses untuk Anggota</h2>
            <p class="text-slate-500 text-sm mt-2">Didesain khusus untuk memberikan transparansi penuh dalam pengelolaan transaksi koperasi Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center font-extrabold text-2xl mb-6">
                    💳
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Simpanan & Piutang</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Pantau rincian saldo simpanan serta saldo piutang anggota secara transparan dan terstruktur kapan saja.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center font-extrabold text-2xl mb-6">
                    📊
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Riwayat Transaksi</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Lihat rekam jejak riwayat transaksi dan pembayaran anggota secara lengkap tanpa perlu antre di kantor.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center font-extrabold text-2xl mb-6">
                    🔒
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Keamanan PIN & HP</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Sistem otentikasi aman menggunakan Nomor HP terdaftar serta proteksi kode PIN pribadi untuk setiap anggota.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
            <div class="flex items-center justify-center gap-3 mb-4">
                <img src="{{ asset('images/koperasi.png') }}" alt="Logo Footer" class="h-8 w-auto brightness-200 grayscale opacity-80">
                <span class="font-bold text-white text-base tracking-tight">KOPKAR RSPB</span>
            </div>
            <p class="text-slate-500 text-xs">&copy; {{ date('Y') }} Koperasi Karyawan RSPB. Seluruh hak cipta dilindungi undang-undang.</p>
        </div>
    </footer>

    <!-- Swiper JS Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.promoSwiper', {
            loop: true,
            grabCursor: true,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
</body>
</html>