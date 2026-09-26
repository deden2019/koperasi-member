<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // 1. Import Facade Hash

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $customer = Customer::where('telepon', $request->telepon)->first();

    if (!$customer || empty($customer->pin)) {
        return back()->with('error', 'Nomor HP atau PIN salah');
    }

    $isValidPin = false;

    // Cek apakah PIN di DB VPS ter-hash Bcrypt atau masih plain text
    if (\Illuminate\Support\Facades\Hash::needsRehash($customer->pin)) {
        // Jika di DB VPS masih plain text (seperti '112233'), cocokan langsung
        if ($customer->pin === $request->pin) {
            $isValidPin = true;
            // Otomatis ubah & simpan PIN ke format Bcrypt di VPS!
            $customer->pin = bcrypt($request->pin);
            $customer->save();
        }
    } else {
        // Jika sudah berupa hash Bcrypt
        $isValidPin = \Illuminate\Support\Facades\Hash::check($request->pin, $customer->pin);
    }

    if (!$isValidPin) {
        return back()->with('error', 'Nomor HP atau PIN salah');
    }

    session([
        'customer_id' => $customer->customer_id,
        'nama_customer' => $customer->nama_customer,
        'kode_customer' => $customer->kode_customer,
    ]);

    $customer->last_login = now();
    $customer->save();

    return redirect('/dashboard');
}

    public function logout()
    {
        session()->flush();

        return redirect('/');
    }
}