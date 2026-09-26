<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // 1. Import Facade Hash

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
            'pin_lama.required' => 'PIN lama wajib diisi',
            'pin_baru.required' => 'PIN baru wajib diisi',
            'pin_baru.digits' => 'PIN harus 6 digit',
            'pin_baru.numeric' => 'PIN harus berupa angka',
            'konfirmasi_pin.required' => 'Konfirmasi PIN wajib diisi',
            'konfirmasi_pin.same' => 'Konfirmasi PIN tidak sama'
        ]);

        $customer = Customer::where(
            'customer_id',
            session('customer_id')
        )->first();

        // 2. Gunakan Hash::check untuk memverifikasi PIN lama
        if (!$customer || !Hash::check($request->pin_lama, $customer->pin)) {
            return back()->with(
                'error',
                'PIN lama tidak sesuai'
            );
        }

        // Catatan: Pengecekan konfirmasi PIN sudah ditangani oleh validasi 'same:pin_baru' di atas,
        // namun jika tetap disimpan tidak masalah.

        // 3. Simpan PIN baru
        // Jika Anda sudah menambahkan mutator setPinAttribute di Model Customer, 
        // nilai $request->pin_baru akan otomatis ter-hash saat save() dipanggil.
        $customer->pin = $request->pin_baru;
        $customer->save();

        return back()->with(
            'success',
            'PIN berhasil diubah'
        );
    }
}