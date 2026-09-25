<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $customer = Customer::where(
            'customer_id',
            session('customer_id')
        )->first();

        return view(
            'profile.index',
            compact('customer')
        );
    }

    public function edit()
    {
        $customer = Customer::where(
            'customer_id',
            session('customer_id')
        )->first();

        return view(
            'profile.edit',
            compact('customer')
        );
    }

   public function update(Request $request)
{
    $request->validate([
        'telepon' => 'required',
        'alamat' => 'nullable',
    ],[
        'telepon.required' => 'Nomor telepon wajib diisi',
    ]);

    $customer = Customer::where(
        'customer_id',
        session('customer_id')
    )->first();

    $customer->telepon = $request->telepon;
    $customer->alamat  = $request->alamat;
    // Baris email dihapus agar tidak error

    $customer->save();

    return redirect('/profile')
        ->with(
            'success',
            'Profil berhasil diperbarui'
        );
}
}