<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        // Mengambil ID dari session login yang sesuai dengan AuthController Anda
        $customerId = session('customer_id'); 

        if (!$customerId) {
            return response()->json(['status' => 'Unauthorized - Belum Login'], 401);
        }

        $subscription = $request->json()->all();

        if (!isset($subscription['endpoint'])) {
            return response()->json(['status' => 'error', 'message' => 'Endpoint tidak ditemukan'], 400);
        }

        // Simpan atau update data ke PostgreSQL berdasarkan customer_id asli yang sedang login
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