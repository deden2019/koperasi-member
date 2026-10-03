<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $transaksi->nota }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tokopedia: {
                            DEFAULT: '#00AA5B',
                            light: '#E8F5E9'
                        }
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS khusus untuk mengoptimalkan tampilan saat dicetak / PDF */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
                padding: 0 !important;
            }
            .print-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 p-4 sm:p-8" onload="window.print()">

    <!-- BAR NAVIGASI & TOMBOL CETAK (HANYA TAMPIL DI LAYAR) -->
    <div class="max-w-3xl mx-auto mb-4 flex justify-between items-center no-print">
        <a href="/transaksi/{{ $transaksi->jual_id }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 text-xs font-bold rounded-xl border border-gray-200 shadow-sm hover:bg-gray-50 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Detail
        </a>
        
        <!-- TOMBOL PENCETAK UTAMA -->
        <button type="button" onclick="window.print()" class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-tokopedia hover:bg-emerald-600 text-white text-xs font-bold rounded-xl shadow-md transition cursor-pointer">
            <i class="fa-solid fa-print text-xs"></i> Cetak / Simpan PDF
        </button>
    </div>

    <!-- INVOICE CARD STYLE TOKOPEDIA -->
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-200 print-card space-y-6">
        
        <!-- HEADER INVOICE: LOGO & STATUS -->
        <div class="flex justify-between items-start border-b border-gray-200 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl overflow-hidden border border-gray-100 flex items-center justify-center bg-white">
                    <img src="{{ asset('images/koperasi.png') }}" alt="Logo Koperasi" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="font-extrabold text-xl text-gray-900 tracking-tight">
                        Kopkar <span class="text-tokopedia">RSPB</span>
                    </h1>
                    <p class="text-xs text-gray-400 font-medium">Koperasi Karyawan Rumah Sakit Pertamina Balikpapan</p>
                </div>
            </div>

            <div class="text-right">
                <h2 class="text-lg font-black text-gray-800 tracking-wider uppercase">INVOICE</h2>
                <span class="inline-block mt-1 px-3 py-1 bg-emerald-50 text-tokopedia text-xs font-bold rounded-md border border-tokopedia/20">
                    SELESAI
                </span>
            </div>
        </div>

        <!-- METADATA TRANSAKSI & PEMBELI -->
        <div class="grid grid-cols-2 gap-6 text-xs">
            <!-- Sisi Kiri: Informasi Transaksi -->
            <div class="space-y-1.5">
                <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Diterbitkan Atas Nama</p>
                <p class="font-bold text-gray-800 text-sm">Kopkar RSPB Official</p>
                <p class="text-gray-600">No. Invoice: <span class="font-mono font-bold text-tokopedia">{{ $transaksi->nota }}</span></p>
                <p class="text-gray-600">Tanggal: <span class="font-medium text-gray-800">{{ date('d F Y', strtotime($transaksi->tanggal)) }}</span></p>
            </div>

<!-- Sisi Kanan: Informasi Pembeli / Member -->
<div class="space-y-1.5 text-right sm:text-left sm:pl-8 sm:border-l sm:border-gray-100">
    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Tujuan Pembelian</p>
    <p class="font-bold text-gray-800 text-sm">{{ session('nama_customer', 'Member Koperasi') }}</p>
    
    <!-- Metode Pembayaran Dinamis -->
    <p class="text-gray-600">
        Metode Pembayaran: 
        <span class="font-semibold uppercase text-gray-800">
            {{ $transaksi->metode_pembayaran ?? $transaksi->jenis_pembayaran ?? $transaksi->metode ?? 'Tunai' }}
        </span>
    </p>
</div>

        <!-- TABEL PRODUK / ITEM -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-y border-gray-200 text-gray-600 font-bold uppercase text-[10px] tracking-wider">
                        <th class="py-3 px-4">Info Produk</th>
                        <th class="py-3 px-2 text-center">Jumlah</th>
                        <th class="py-3 px-3 text-right">Harga Satuan</th>
                        <th class="py-3 px-4 text-right">Total Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-800">
                    @forelse($items as $item)
                        <tr>
                            <td class="py-3.5 px-4">
                                <p class="font-bold text-gray-800 text-xs sm:text-sm">{{ $item->nama_produk }}</p>
                                @if($item->diskon > 0)
                                    <p class="text-[10px] text-red-500 font-semibold mt-0.5">
                                        Diskon: -Rp {{ number_format($item->diskon, 0, ',', '.') }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-3.5 px-2 text-center font-semibold">{{ $item->jumlah }}</td>
                            <td class="py-3.5 px-3 text-right font-medium">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-4 text-right font-bold text-gray-900">
                                Rp {{ number_format(($item->jumlah * $item->harga_jual) - $item->diskon, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-400">Tidak ada rincian barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- RINCIAN PEMBAYARAN / TOTAL -->
        <div class="flex flex-col sm:flex-row justify-between items-start border-t border-gray-200 pt-6 gap-6">
            <!-- Catatan Kiri -->
            <div class="text-[11px] text-gray-400 space-y-1 max-w-xs">
                <p class="font-bold text-gray-600">Catatan:</p>
                <p>Invoice ini sah dan diproses secara otomatis oleh sistem komputer Koperasi Karyawan RSPB.</p>
            </div>

            <!-- Rincian Total Kanan -->
            <div class="w-full sm:w-64 space-y-2 text-xs">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal Harga</span>
                    <span class="font-semibold text-gray-800">Rp {{ number_format($transaksi->total_nota, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Biaya Layanan</span>
                    <span class="font-semibold text-tokopedia">Rp 0</span>
                </div>
                <div class="border-t border-gray-200 pt-2 flex justify-between items-center text-sm font-black text-gray-900">
                    <span>Total Tagihan</span>
                    <span class="text-tokopedia text-base">Rp {{ number_format($transaksi->total_nota, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- FOOTER INVOICE -->
        <div class="border-t border-dashed border-gray-200 pt-4 text-center text-[10px] text-gray-400">
            <p>Terima kasih telah berbelanja di Kopkar RSPB.</p>
        </div>

    </div>

</body>
</html>