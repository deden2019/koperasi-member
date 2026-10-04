<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload & Kelola PDF Piutang Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- jQuery & Select2 CSS/JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border-radius: 0.75rem !important;
            border-color: #e5e7eb !important;
            padding: 6px 12px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px !important;
            font-size: 0.875rem !important;
            color: #374151 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-4 md:p-8 flex justify-center">

    <div class="w-full max-w-4xl space-y-6">
        
        <!-- CARD FORM UPLOAD -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <!-- Header & Navigasi -->
            <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-gray-800">Upload PDF Piutang</h1>
                        <p class="text-xs text-gray-500">Khusus Admin Deden (08115965955)</p>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" class="text-xs text-gray-500 hover:text-gray-700 flex items-center gap-1 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    Dashboard
                </a>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="p-3 mb-4 text-xs font-semibold text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Notifikasi Error -->
            @if(session('error'))
                <div class="p-3 mb-4 text-xs font-semibold text-rose-800 bg-rose-50 rounded-xl border border-rose-200 flex items-center gap-2">
                    <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Upload / Update -->
            <form action="{{ route('admin.upload-pdf.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Pilih Customer -->
                <div>
                    <label for="customer_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">Pilih Customer</label>
                    <select name="customer_id" id="customer_id" class="w-full select2" required>
                        <option value="">-- Pilih Customer --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->customer_id }}" {{ old('customer_id') == $c->customer_id ? 'selected' : '' }}>
                                {{ $c->kode_customer }} - {{ $c->nama_customer }} {{ $c->file_pdf_piutang ? '(Sudah Ada File)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilih PDF -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Pilih File PDF</label>
                    <input type="file" name="file_pdf" accept="application/pdf" required class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-200 rounded-xl cursor-pointer">
                    <p class="text-[11px] text-gray-400 mt-1">Format file .pdf, maksimal 5MB. Jika customer sudah punya file, file lama otomatis diganti.</p>
                    @error('file_pdf')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    Simpan / Perbarui PDF Customer
                </button>
            </form>
        </div>

        <!-- CARD LIST FILE PDF TERUPLOAD -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-rose-600"></i>
                    Daftar File PDF Piutang Customer
                </h2>
                <span class="text-xs bg-gray-100 text-gray-600 font-semibold px-2.5 py-1 rounded-full">
                    Total: {{ $uploadedList->count() }} Customer
                </span>
            </div>

            @if($uploadedList->isEmpty())
                <div class="text-center py-8 text-gray-400 text-xs">
                    <i class="fa-solid fa-folder-open text-3xl mb-2 text-gray-300"></i>
                    <p>Belum ada file PDF yang diunggah.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[11px] font-bold text-gray-400 uppercase bg-gray-50 border-y border-gray-100">
                                <th class="p-3">Customer</th>
                                <th class="p-3">Status File</th>
                                <th class="p-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs">
                            @foreach($uploadedList as $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-3">
                                        <div class="font-bold text-gray-800">{{ $item->nama_customer }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $item->kode_customer }}</div>
                                    </td>
                                    <td class="p-3">
                                        <!-- BARU (Lewat Route Secure Stream) -->
<a href="{{ route('admin.upload-pdf.preview', $item->customer_id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-rose-50 text-rose-600 font-semibold text-[11px] hover:bg-rose-100 transition">
    <i class="fa-solid fa-file-pdf"></i>
    Lihat PDF
</a>
                                    </td>
                                    <td class="p-3 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <!-- Tombol Edit (Pilih otomatis ke dropdown) -->
                                            <button type="button" onclick="editCustomer('{{ $item->customer_id }}')" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Ganti File PDF">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.upload-pdf.destroy', $item->customer_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus PDF untuk customer {{ $item->nama_customer }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus PDF">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Pilih Customer --",
                allowClear: true
            });
        });

        function editCustomer(customerId) {
            $('#customer_id').val(customerId).trigger('change');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>