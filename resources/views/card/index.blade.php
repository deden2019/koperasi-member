@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        
        <!-- HEADER & TOMBOL KEMBALI -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-3xl shadow-sm mb-8 gap-4 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div>
                    <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">E-Membership</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Kartu Anggota Digital</h2>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Tombol Download Kartu -->
                <button onclick="downloadCard()" class="flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition text-sm shadow-lg shadow-emerald-600/20">
                    <i class="fa-solid fa-download"></i> Download Kartu
                </button>

                <!-- Tombol Kembali ke Dashboard -->
                <a href="/dashboard" class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- KARTU ANGGOTA UTAMA (Diberi ID 'digital-card' agar bisa dibaca script) -->
        <div id="digital-card" class="bg-gradient-to-br from-emerald-600 via-teal-600 to-teal-800 text-white rounded-3xl p-8 sm:p-10 shadow-xl shadow-emerald-600/20 relative overflow-hidden">
            
            <!-- Aksen Background Dekoratif -->
            <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative z-10">
                
                <!-- Informasi Teks Kartu -->
                <div class="space-y-6 flex-1">
                    <div>
                        <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-semibold tracking-wider uppercase text-emerald-100 mb-3">
                            <i class="fa-solid fa-shield-halved mr-1"></i> Member Resmi Koperasi
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                            {{ $customer->nama_customer }}
                        </h2>
                    </div>

                    <div class="space-y-3 pt-2 border-t border-white/10">
                        <div>
                            <p class="text-xs text-emerald-100 font-medium">Kode Anggota</p>
                            <p class="text-lg sm:text-xl font-bold tracking-wide text-white">
                                {{ $customer->kode_customer }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-emerald-100 font-medium">Nomor Telepon</p>
                            <p class="text-base font-semibold text-white flex items-center gap-2">
                                <i class="fa-solid fa-phone text-xs text-emerald-200"></i> {{ $customer->telepon }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bagian QR Code -->
                <div class="bg-white p-4 rounded-2xl shadow-lg flex flex-col items-center justify-center mx-auto md:mx-0">
                    <div class="overflow-hidden rounded-xl">
                        {!! QrCode::size(180)->generate($customer->kode_customer) !!}
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-2">Scan QR</span>
                </div>

            </div>

        </div>

    </div>

    <!-- CDN html2canvas untuk fitur download gambar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function downloadCard() {
            const card = document.getElementById('digital-card');
            
            // Opsi tambahan agar hasil render gambar lebih jernih (scale: 2)
            html2canvas(card, { scale: 2, useCORS: true }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Kartu-Anggota-{{ $customer->kode_customer }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>
@endsection