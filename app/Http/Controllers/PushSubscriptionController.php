<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        // Ganti session('customer_id') dengan nama session login Anda yang sebenarnya
        $customerId = session('nama_session_login_anda');   

        $subscription = $request->json()->all();

        // Pastikan data endpoint ada
        if (!isset($subscription['endpoint'])) {
            return response()->json(['status' => 'error', 'message' => 'Endpoint tidak ditemukan'], 400);
        }

        // Simpan atau update data ke tabel PostgreSQL
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

        return response()->json(['status' => 'success']);
    }
}