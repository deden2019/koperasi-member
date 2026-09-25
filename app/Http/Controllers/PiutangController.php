<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PiutangController extends Controller
{
    public function index()
    {
        $piutang = DB::table('t_jual_produk')
            ->where('customer_id', session('customer_id'))
            ->whereRaw('total_nota > total_pelunasan')
            ->orderByDesc('tanggal')
            ->get();

        return view(
            'piutang.index',
            compact('piutang')
        );
    }

public function terbayar()
{
    $pembayaran = DB::table('t_item_pembayaran_piutang_produk as i')
        ->join(
            't_pembayaran_piutang_produk as p',
            'i.pembayaran_piutang_id',
            '=',
            'p.pembayaran_piutang_id'
        )
        ->join(
            't_jual_produk as j',
            'i.jual_id',
            '=',
            'j.jual_id'
        )
        ->select(
            'p.tanggal as tanggal_bayar',
            'p.nota as nota_bayar',
            'j.nota as nota_jual',
            'i.nominal',
            'i.keterangan'
        )
        ->where(
            'j.customer_id',
            session('customer_id')
        )
        ->where('p.is_tunai', false)
        ->orderByDesc('p.tanggal')
        ->get();

    return view(
        'piutang.terbayar',
        compact('pembayaran')
    );
}

}