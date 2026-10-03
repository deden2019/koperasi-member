<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $transaksi->nota }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Pengaturan Ukuran Kertas Dinamis saat Print */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .print-wrapper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 auto !important;
            }
        }

        /* Ukuran Mode POS 58mm */
        body.paper-58 {
            font-size: 11px;
        }
        body.paper-58 .print-wrapper {
            width: 58mm;
        }

        /* Ukuran Mode POS 80mm */
        body.paper-80 {
            font-size: 12px;
        }
        body.paper-80 .print-wrapper {
            width: 80mm;
        }

        /* Ukuran Mode Standard Inkjet / Laser (A4/Letter) */
        body.paper-full {
            font-size: 13px;
        }
        body.paper-full .print-wrapper {
            width: 100%;
            max-width: 650px;
        }

        @page {
            margin: 4mm;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans p-2 sm:p-6 paper-80" id="bodyPage">

    <!-- BAR NAVIGASI & PILIHAN UKURAN KERTAS (TIDAK TERCETAK) -->
    <div class="max-w-xl mx-auto mb-4 bg-white p-3 rounded-xl shadow-sm border border-gray-200 no-print space-y-3">
        <div class="flex items-center justify-between border-b pb-2">
            <span class="text-xs font-bold text-gray-700">Pilih Ukuran Kertas / Printer:</span>
            <button onclick="window.close()" class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded hover:bg-gray-200">
                &larr; Tutup
            </button>
        </div>

        <div class="grid grid-cols-3 gap-2">
            <button onclick="setPaper('58')" id="btn-58" class="px-2 py-1.5 border text-xs font-semibold rounded-lg text-center hover:bg-emerald-50">
                POS 58mm
            </button>
            <button onclick="setPaper('80')" id="btn-80" class="px-2 py-1.5 border text-xs font-semibold rounded-lg text-center bg-emerald-600 text-white border-emerald-600">
                POS 80mm
            </button>
            <button onclick="setPaper('full')" id="btn-full" class="px-2 py-1.5 border text-xs font-semibold rounded-lg text-center hover:bg-emerald-50">
                Inkjet / A4
            </button>
        </div>

        <button onclick="window.print()" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition">
            <i class="fa-solid fa-print mr-1"></i> Cetak Invoice
        </button>
    </div>

    <!-- STRUK / INVOICE LAYOUT -->
    <div class="print-wrapper mx-auto bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-gray-800">
        
        <!-- HEADER KOPERASI -->
        <div class="text-center border-b border-dashed border-gray-300 pb-3 mb-3">
            <h1 class="font-bold text-base tracking-tight uppercase">KOPKAR RSPB</h1>
            <p class="text-[10px] text-gray-500">Koperasi Karyawan RSPB</p>
            <p class="text-[10px] text-gray-400">Bukti Pembelian Resmi</p>
        </div>

        <!-- INFORMASI TRANSAKSI -->
        <div class="text-[11px] space-y-0.5 border-b border-dashed border-gray-300 pb-2 mb-3">
            <div class="flex justify-between">
                <span class="text-gray-500">No. Invoice:</span>
                <span class="font-bold text-gray-800">{{ $transaksi->nota }}</span>
            </div>
            
            <!-- TANGGAL TANPA JAM -->
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal:</span>
                <span>{{ date('d/m/Y', strtotime($transaksi->tanggal)) }}</span>
            </div>

            <!-- METODE PEMBAYARAN DINAMIS DARI DATABASE -->
            <div class="flex justify-between">
                <span class="text-gray-500">Pembayaran:</span>
                <span class="font-semibold uppercase">
                    {{ $transaksi->metode_pembayaran ?? $transaksi->jenis_pembayaran ?? $transaksi->metode ?? 'Tunai' }}
                </span>
            </div>
        </div>

        <!-- TABEL DETAIL BARANG -->
        <div class="border-b border-dashed border-gray-300 pb-3 mb-3">
            <table class="w-full text-left text-[11px]">
                <thead>
                    <tr class="border-b border-gray-200 text-gray-400">
                        <th class="pb-1">Item</th>
                        <th class="pb-1 text-center">Qty</th>
                        <th class="pb-1 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($items as $item)
                        <tr>
                            <td class="py-1.5 pr-1">
                                <div class="font-medium text-gray-800 leading-tight">{{ $item->nama_produk }}</div>
                                <div class="text-[10px] text-gray-400">@ Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</div>
                                @if($item->diskon > 0)
                                    <div class="text-[10px] text-red-500">Disc: -Rp {{ number_format($item->diskon, 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td class="py-1.5 text-center align-top">{{ $item->jumlah }}</td>
                            <td class="py-1.5 text-right font-semibold align-top">
                                Rp {{ number_format(($item->jumlah * $item->harga_jual) - $item->diskon, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- TOTAL HARGA -->
        <div class="space-y-1 text-[11px] mb-4">
            <div class="flex justify-between text-gray-600">
                <span>Total Barang:</span>
                <span>Rp {{ number_format($transaksi->total_nota, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Biaya Layanan:</span>
                <span class="text-emerald-600">Bebas Biaya</span>
            </div>
            <div class="flex justify-between font-bold text-xs pt-1.5 border-t border-gray-300 text-gray-900">
                <span>Total Bayar:</span>
                <span>Rp {{ number_format($transaksi->total_nota, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="text-center text-[10px] text-gray-400 border-t border-dashed border-gray-300 pt-3 space-y-0.5">
            <p class="font-medium text-gray-600">Terima kasih atas kunjungan Anda</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
        </div>

    </div>

    <!-- SCRIPT GANTI UKURAN -->
    <script>
        function setPaper(size) {
            const body = document.getElementById('bodyPage');
            body.className = body.className.replace(/paper-\w+/g, '');
            body.classList.add('paper-' + size);

            ['58', '80', 'full'].forEach(s => {
                const btn = document.getElementById('btn-' + s);
                if (s === size) {
                    btn.className = "px-2 py-1.5 border text-xs font-semibold rounded-lg text-center bg-emerald-600 text-white border-emerald-600";
                } else {
                    btn.className = "px-2 py-1.5 border text-xs font-semibold rounded-lg text-center hover:bg-emerald-50 text-gray-700";
                }
            });
        }

        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 300);
        };
    </script>
</body>
</html>