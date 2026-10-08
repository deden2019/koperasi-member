<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        try {

            \Log::info('MASUK STORE PUSH');

            $customerId = session('customer_id') ?? 1;

            $subscription = $request->json()->all();

            \Log::info('DATA SUBSCRIPTION', [
                'customer_id' => $customerId,
                'subscription' => $subscription
            ]);

            $endpoint = $subscription['endpoint'] ?? $request->input('endpoint');

            if (!$endpoint) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Endpoint tidak ditemukan'
                ], 400);
            }

            $keys = $subscription['keys'] ?? [];

            $p256dh = $keys['p256dh'] ?? '';
            $auth = $keys['auth'] ?? '';

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

            \Log::info('BERHASIL SIMPAN PUSH');

            return response()->json([
                'status' => 'success'
            ]);

        } catch (\Throwable $e) {

            \Log::error('PUSH ERROR', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
