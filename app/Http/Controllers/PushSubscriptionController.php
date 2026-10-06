<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $customerId = session('customer_id'); // Mengambil ID dari session login anggota
        if (!$customerId) {
            return response()->json(['status' => 'Unauthorized'], 401);
        }

        $subscription = $request->json()->all();

        // Simpan atau update data subscription berdasarkan customer_id
        DB::table('push_subscriptions')->updateOrInsert(
            ['customer_id' => $customerId],
            [
                'endpoint' => $subscription['endpoint'],
                'keys_p256dh' => $subscription['keys']['p256dh'],
                'keys_auth' => $subscription['keys']['auth'],
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return response()->json(['status' => 'success']);
    }
}