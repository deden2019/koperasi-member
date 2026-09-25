<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index()
    {
        $transaksi = DB::table('t_jual_produk')
            ->where(
                'customer_id',
                session('customer_id')
            )
            ->orderByDesc('tanggal')
            ->get();

        return view(
            'pembayaran.index',
            compact('transaksi')
        );
    }
}