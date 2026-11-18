<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Services\PushNotificationService;

Route::post('/send-transaction-notification', function (Request $request) {

    \Log::info('TRANSAKSI NOTIF MASUK', [
        'customer_id' => $request->customer_id,
        'nota'        => $request->nota,
        'total'       => $request->total
    ]);

    PushNotificationService::send(
        $request->customer_id,
        'Belanja Berhasil',
        'Nota ' . $request->nota .
        ' sebesar Rp ' .
        number_format($request->total, 0, ',', '.')
    );

    return response()->json([
        'status' => 'success'
    ]);
});
