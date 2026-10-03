<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('t_jual_produk')
            ->where('customer_id', session('customer_id'))
            ->orderByDesc('tanggal');

        // Fitur pencarian berdasarkan nomor nota
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nota', 'like', '%' . $request->search . '%');
        }

        $transaksi = $query->get();

        return view(
            'transaksi.index',
            compact('transaksi')
        );
    }

    public function show($jualId)
    {
        $items = DB::table('t_item_jual_produk as d')
            ->join(
                'm_produk as p',
                'd.produk_id',
                '=',
                'p.produk_id'
            )
            ->where('d.jual_id', $jualId)
            ->select(
                'p.nama_produk',
                'd.jumlah',
                'd.harga_jual',
                'd.diskon'
            )
            ->get();

        // Ambil data transaksi langsung tanpa JOIN ke tabel yang tidak ada
        $transaksi = DB::table('t_jual_produk')
            ->where('jual_id', $jualId)
            ->where('customer_id', session('customer_id'))
            ->first();

        // Validasi jika transaksi tidak ditemukan
        if (!$transaksi) {
            return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Tentukan metode pembayaran secara otomatis berdasarkan kolom yang ada di t_jual_produk
        // Pada OpenRetail, jika ada sisa piutang / total_pelunasan < grand_total / tempo -> Potong Gaji / Kredit
        $isKredit = false;

        if (isset($transaksi->is_kredit) && $transaksi->is_kredit) {
            $isKredit = true;
        } elseif (isset($transaksi->total_pelunasan) && isset($transaksi->grand_total) && ($transaksi->grand_total - $transaksi->total_pelunasan > 0)) {
            $isKredit = true;
        } elseif (isset($transaksi->sisa_nota) && $transaksi->sisa_nota > 0) {
            $isKredit = true;
        }

        // Simpan nama metode pembayaran ke properti dinamis
        $transaksi->nama_metode_pembayaran = $isKredit 
            ? 'Potong Gaji / Simpanan Koperasi' 
            : 'Tunai / Cash';

        return view(
            'transaksi.show',
            compact('items', 'transaksi')
        );
    }

    /**
     * Fitur Cetak Invoice / Nota Tokopedia Style
     */
    public function print($jualId)
    {
        $transaksi = DB::table('t_jual_produk')
            ->where('jual_id', $jualId)
            ->where('customer_id', session('customer_id'))
            ->first();

        if (!$transaksi) {
            abort(404, 'Data Invoice Tidak Ditemukan');
        }

        $items = DB::table('t_item_jual_produk as d')
            ->join(
                'm_produk as p',
                'd.produk_id',
                '=',
                'p.produk_id'
            )
            ->where('d.jual_id', $jualId)
            ->select(
                'p.nama_produk',
                'd.jumlah',
                'd.harga_jual',
                'd.diskon'
            )
            ->get();

        return view(
            'transaksi.print',
            compact('items', 'transaksi')
        );
    }
}