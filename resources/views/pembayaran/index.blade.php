@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-3 sm:px-6 py-4 sm:py-6 space-y-4">

    <!-- 1. TOP BAR / NAVIGASI & HEADER -->
    <div class="flex items-center justify-between gap-3">
        <a href="/dashboard" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-gray-700 hover:text-tokopedia transition bg-white px-3.5 py-2 rounded-xl shadow-sm border border-gray-200">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Dashboard</span>
        </a>
        <div class="text-right">
            <h1 class="text-base sm:text-xl font-extrabold text-gray-900 leading-tight">Riwayat Pembayaran</h1>
            <p class="text-[11px] sm:text-xs text-gray-500 hidden sm:block">Pantau semua status transaksi keanggotaan Anda</p>
        </div>
    </div>

    <!-- 2. SEARCH BAR & FILTER COMPONENT (TOKOPEDIA STYLE) -->
    <div class="bg-white p-3 sm:p-4 rounded-2xl border border-gray-200 shadow-sm space-y-3">
        <!-- Search Input -->
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" id="searchInput" onkeyup="filterTransaksi()" placeholder="Cari nomor nota transaksi..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:outline-none focus:border-tokopedia transition">
        </div>

        <!-- Quick Filter Badges -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs scrollbar-none">
            <button onclick="setFilter('all')" class="filter-btn active px-3 py-1.5 rounded-lg border font-semibold whitespace-nowrap transition bg-tokopedia text-white border-tokopedia" data-filter="all">
                Semua
            </button>
            <button onclick="setFilter('lunas')" class="filter-btn px-3 py-1.5 rounded-lg border font-semibold whitespace-nowrap transition bg-gray-50 text-gray-600 border-gray-200 hover:border-tokopedia" data-filter="lunas">
                <i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Lunas
            </button>
            <button onclick="setFilter('piutang')" class="filter-btn px-3 py-1.5 rounded-lg border font-semibold whitespace-nowrap transition bg-gray-50 text-gray-600 border-gray-200 hover:border-tokopedia" data-filter="piutang">
                <i class="fa-solid fa-clock text-rose-500 mr-1"></i> Piutang
            </button>
            <button onclick="setFilter('tunai')" class="filter-btn px-3 py-1.5 rounded-lg border font-semibold whitespace-nowrap transition bg-gray-50 text-gray-600 border-gray-200 hover:border-tokopedia" data-filter="tunai">
                Tunai
            </button>
            <button onclick="setFilter('qris')" class="filter-btn px-3 py-1.5 rounded-lg border font-semibold whitespace-nowrap transition bg-gray-50 text-gray-600 border-gray-200 hover:border-tokopedia" data-filter="qris">
                QRIS / Kartu
            </button>
        </div>
    </div>

    <!-- 3. DAFTAR KARTU TRANSAKSI -->
    <div class="space-y-3" id="transaksiContainer">
        @forelse($transaksi as $item)
            @php
                $metode = 'Lainnya';
                $badgeMetode = 'bg-gray-100 text-gray-700 border-gray-200';
                $filterCategory = 'lainnya';
                
                if($item->bayar_tunai > 0){
                    $metode = 'Tunai';
                    $badgeMetode = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    $filterCategory = 'tunai';
                }
                if($item->bayar_kartu > 0){
                    $metode = 'QRIS / Kartu';
                    $badgeMetode = 'bg-blue-50 text-blue-700 border-blue-200';
                    $filterCategory = 'qris';
                }
                if($item->total_nota > $item->total_pelunasan){
                    $metode = 'Piutang';
                    $badgeMetode = 'bg-rose-50 text-rose-700 border-rose-200';
                    $filterCategory = 'piutang';
                }

                $isLunas = $item->total_pelunasan >= $item->total_nota;
                $statusCategory = $isLunas ? 'lunas' : 'piutang';
            @endphp

            <div class="transaksi-card bg-white rounded-2xl p-4 border border-gray-200 shadow-sm hover:border-tokopedia/50 transition duration-150 space-y-3" 
                 data-nota="{{ strtolower($item->nota) }}" 
                 data-status="{{ $statusCategory }}" 
                 data-metode="{{ $filterCategory }}">
                
                <!-- Card Header: Kategori & Tanggal -->
                <div class="flex items-center justify-between pb-2 border-b border-gray-100 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-50 text-tokopedia flex items-center justify-center font-bold">
                            <i class="fa-solid fa-bag-shopping text-xs"></i>
                        </span>
                        <div>
                            <span class="font-bold text-gray-900 block leading-tight">Belanja Koperasi</span>
                            <span class="text-[10px] text-gray-400 font-mono">{{ date('d M Y • H:i', strtotime($item->tanggal)) }}</span>
                        </div>
                    </div>

                    <!-- Badge Status Pelunasan -->
                    @if($isLunas)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                            <i class="fa-solid fa-circle-check text-[10px]"></i> Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-200">
                            <i class="fa-solid fa-clock text-[10px]"></i> Belum Lunas
                        </span>
                    @endif
                </div>

                <!-- Card Body: Detail Nota & Total -->
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">No. Invoice / Nota</span>
                        @if(isset($item->id))
                            <a href="/transaksi/{{ $item->id }}" class="text-xs sm:text-sm font-bold font-mono text-tokopedia hover:underline inline-flex items-center gap-1">
                                {{ $item->nota }}
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        @else
                            <span class="text-xs sm:text-sm font-bold font-mono text-gray-800">{{ $item->nota }}</span>
                        @endif
                    </div>

                    <div class="text-right">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Total Belanja</span>
                        <span class="text-sm sm:text-base font-extrabold text-gray-900">
                            Rp {{ number_format($item->total_nota, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Card Footer: Metode Bayar & Tombol Aksi -->
                <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Metode:</span>
                        <span class="px-2 py-0.5 rounded-md text-[11px] font-bold border {{ $badgeMetode }}">
                            {{ $metode }}
                        </span>
                    </div>

                    @if(isset($item->id))
                        <a href="/transaksi/{{ $item->id }}" class="text-tokopedia font-bold hover:text-tokopedia-hover text-xs flex items-center gap-1">
                            Lihat Struk <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    @endif
                </div>

            </div>
        @empty
            <div id="emptyState" class="bg-white rounded-2xl p-8 sm:p-12 text-center border border-gray-200 shadow-sm">
                <div class="w-16 h-16 bg-emerald-50 text-tokopedia rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-1">Belum Ada Riwayat Transaksi</h3>
                <p class="text-xs text-gray-500 max-w-xs mx-auto">Semua transaksi belanja atau pembayaran piutang Anda akan tampil di sini.</p>
            </div>
        @endforelse

        <!-- Empty State untuk Hasil Pencarian Kosong -->
        <div id="noSearchResult" class="hidden bg-white rounded-2xl p-8 text-center border border-gray-200">
            <i class="fa-solid fa-magnifying-glass text-gray-300 text-3xl mb-2 block"></i>
            <h4 class="font-bold text-gray-800 text-sm">Transaksi tidak ditemukan</h4>
            <p class="text-xs text-gray-400">Coba kata kunci atau filter status yang lain.</p>
        </div>
    </div>

</div>

<!-- SCRIPT FILTER & PENCARIAN CLIENT-SIDE -->
<script>
    let currentFilter = 'all';

    function setFilter(filter) {
        currentFilter = filter;
        
        // Style Tombol Active
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if(btn.dataset.filter === filter) {
                btn.className = "filter-btn active px-3 py-1.5 rounded-lg border font-semibold whitespace-nowrap transition bg-tokopedia text-white border-tokopedia";
            } else {
                btn.className = "filter-btn px-3 py-1.5 rounded-lg border font-semibold whitespace-nowrap transition bg-gray-50 text-gray-600 border-gray-200 hover:border-tokopedia";
            }
        });

        filterTransaksi();
    }

    function filterTransaksi() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const cards = document.querySelectorAll('.transaksi-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const nota = card.dataset.nota;
            const status = card.dataset.status;
            const metode = card.dataset.metode;

            const matchSearch = nota.includes(searchValue);
            let matchFilter = false;

            if (currentFilter === 'all') {
                matchFilter = true;
            } else if (currentFilter === 'lunas' || currentFilter === 'piutang') {
                matchFilter = (status === currentFilter);
            } else {
                matchFilter = (metode === currentFilter);
            }

            if (matchSearch && matchFilter) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Tampilkan pesan jika hasil filter/search kosong
        const noResult = document.getElementById('noSearchResult');
        if (cards.length > 0 && visibleCount === 0) {
            noResult.classList.remove('hidden');
        } else {
            noResult.classList.add('hidden');
        }
    }
</script>
@endsection