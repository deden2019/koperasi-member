<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = DB::table('t_jual_produk')
            ->where('customer_id', session('customer_id'))
            ->orderByDesc('tanggal')
            ->get();

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

    $transaksi = DB::table('t_jual_produk')
        ->where('jual_id', $jualId)
        ->first();

    return view(
        'transaksi.show',
        compact('items', 'transaksi')
    );
}
}