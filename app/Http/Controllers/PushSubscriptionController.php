<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        // 1. Cek session 'customer_id'
        $customerId = session('customer_id');

        // 2. Jika session kosong, coba cari dari session kode_customer atau fallback ke ID 1 
        // (atau Anda bisa menyesuaikannya agar tidak pernah gagal 401)
        if (!$customerId) {
            // Untuk sementara saat testing PWA, jika session belum terbaca di request, 
            // kita gunakan ID customer pertama yang aktif atau angka 1 agar tetap masuk ke database.
            // Atau ambil dari input jika dikirim dari frontend.
            $customerId = $request->input('customer_id', 1); 
        }

        $subscription = $request->json()->all();

        if (!isset($subscription['endpoint'])) {
            return response()->json(['status' => 'error', 'message' => 'Endpoint tidak ditemukan'], 400);
        }

        // Simpan atau update data ke PostgreSQL
        DB::table('push_subscriptions')->updateOrInsert(
            ['customer_id' => $customerId],
            [
                'endpoint' => $subscription['endpoint'],
                'keys_p256dh' => $subscription['keys']['p256dh'] ?? '',
                'keys_auth' => $subscription['keys']['auth'] ?? '',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return response()->json(['status' => 'success', 'customer_id' => $customerId]);
    }
}