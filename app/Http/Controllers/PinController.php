<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class PinController extends Controller
{
    public function index()
    {
        return view('pin.index');
    }

    public function update(Request $request)
    {
$request->validate([
    'pin_lama' => 'required',
    'pin_baru' => 'required|digits:6|numeric',
    'konfirmasi_pin' => 'required|same:pin_baru'
], [
    'pin_baru.digits' => 'PIN harus 6 digit',
    'pin_baru.numeric' => 'PIN harus berupa angka',
    'konfirmasi_pin.same' => 'Konfirmasi PIN tidak sama'
]);


        $customer = Customer::where(
            'customer_id',
            session('customer_id')
        )->first();

        if ($customer->pin != $request->pin_lama) {

            return back()->with(
                'error',
                'PIN lama tidak sesuai'
            );
        }

if ($request->pin_baru != $request->konfirmasi_pin) {

    return back()->with(
        'error',
        'Konfirmasi PIN tidak sama'
    );
}

        $customer->pin = $request->pin_baru;
        $customer->save();

        return back()->with(
            'success',
            'PIN berhasil diubah'
        );
    }
}