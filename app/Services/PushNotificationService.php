<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushNotificationService
{
    public static function send($customerId, $title, $body)
    {
        $subscriptions = DB::table('push_subscriptions')
            ->where('customer_id', $customerId)
            ->get();

        if ($subscriptions->isEmpty()) {
            return false;
        }

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => 'mailto:admin@kopkarrspb.id',
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ]);

        foreach ($subscriptions as $row) {

            $subscription = Subscription::create([
                'endpoint' => $row->endpoint,
                'publicKey' => $row->keys_p256dh,
                'authToken' => $row->keys_auth,
            ]);

            $payload = json_encode([
                'title' => $title,
                'body' => $body
            ]);

            $webPush->queueNotification(
                $subscription,
                $payload
            );
        }

        foreach ($webPush->flush() as $report) {
            // optional log
        }

        return true;
    }
}
