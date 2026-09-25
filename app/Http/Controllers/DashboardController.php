<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('customer_id')) {
            return redirect('/');
        }

        $dashboard = DB::table('m_customer as c')
            ->leftJoin(
                't_jual_produk as j',
                'c.customer_id',
                '=',
                'j.customer_id'
            )
            ->selectRaw('
                c.kode_customer,
                c.nama_customer,
                COUNT(j.jual_id) jumlah_transaksi,
                COALESCE(SUM(j.total_nota),0) total_belanja
            ')
            ->where(
                'c.customer_id',
                session('customer_id')
            )
            ->groupBy(
                'c.kode_customer',
                'c.nama_customer'
            )
            ->first();

        // Belanja Bulan Ini
        $bulanIni = DB::table('t_jual_produk')
            ->where('customer_id', session('customer_id'))
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total_nota');

        // Transaksi Terakhir
        $transaksiTerakhir = DB::table('t_jual_produk')
            ->where('customer_id', session('customer_id'))
            ->orderByDesc('tanggal')
            ->first();

        // Total Piutang
        $totalPiutang = DB::table('t_jual_produk')
            ->where('customer_id', session('customer_id'))
            ->whereRaw('total_nota > total_pelunasan')
            ->sum(DB::raw('(total_nota - total_pelunasan)'));

        // Total Piutang Terbayar
        $totalTerbayar = DB::table('t_item_pembayaran_piutang_produk as p')
            ->join(
                't_jual_produk as j',
                'p.jual_id',
                '=',
                'j.jual_id'
            )
            ->where('j.customer_id', session('customer_id'))
            ->sum('p.nominal');

        return view(
            'dashboard.index',
            compact(
                'dashboard',
                'bulanIni',
                'transaksiTerakhir',
                'totalPiutang',
                'totalTerbayar'
            )
        );
    }
}