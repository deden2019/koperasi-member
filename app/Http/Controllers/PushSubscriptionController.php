<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        // Mengambil ID dari session login, atau fallback ke 1 jika session belum terbaca di background
        $customerId = session('customer_id') ?? 1;

        $subscription = $request->json()->all();

        // Pastikan endpoint ada
        $endpoint = $subscription['endpoint'] ?? $request->input('endpoint');
        
        if (!$endpoint) {
            return response()->json(['status' => 'error', 'message' => 'Endpoint tidak ditemukan'], 400);
        }

        $keys = $subscription['keys'] ?? [];
        $p256dh = $keys['p256dh'] ?? $request->input('keys_p256dh', '');
        $auth = $keys['auth'] ?? $request->input('keys_auth', '');

        // Simpan atau update data ke tabel PostgreSQL
        DB::table('push_subscriptions')->updateOrInsert(
            ['customer_id' => $customerId],
            [
                'endpoint' => $endpoint,
                'keys_p256dh' => $p256dh,
                'keys_auth' => $auth,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return response()->json(['status' => 'success', 'customer_id' => $customerId]);
    }
}