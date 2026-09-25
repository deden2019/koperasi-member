<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $customer = Customer::where('telepon', $request->telepon)
            ->where('pin', $request->pin)
            ->first();

        if (!$customer) {
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