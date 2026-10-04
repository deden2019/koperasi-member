<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminCustomerController extends Controller
{
    private function checkAccess()
    {
        $customerId = session('customer_id');

        if (!$customerId) {
            abort(403, 'Anda belum login.');
        }

        $customer = DB::table('m_customer')->where('customer_id', $customerId)->first();
        $phone = $customer->telepon ?? $customer->no_hp ?? $customer->hp ?? '';
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        if ($cleanPhone !== '08115965955') {
            abort(403, 'Akses Ditolak. Halaman ini khusus untuk Admin (08115965955).');
        }
    }

    public function indexUploadPdf()
    {
        $this->checkAccess();

        $customers = DB::table('m_customer')
            ->select('customer_id', 'kode_customer', 'nama_customer', 'file_pdf_piutang')
            ->orderBy('nama_customer', 'asc')
            ->get();

        $uploadedList = DB::table('m_customer')
            ->select('customer_id', 'kode_customer', 'nama_customer', 'file_pdf_piutang')
            ->whereNotNull('file_pdf_piutang')
            ->where('file_pdf_piutang', '!=', '')
            ->orderBy('nama_customer', 'asc')
            ->get();

        return view('admin.upload-pdf', compact('customers', 'uploadedList'));
    }

    public function storeUploadPdf(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'customer_id' => 'required',
            'file_pdf'    => 'required|mimes:pdf|max:5120',
        ]);

        $customerId = $request->customer_id;
        $customer = DB::table('m_customer')->where('customer_id', $customerId)->first();

        if ($request->hasFile('file_pdf')) {
            if ($customer && !empty($customer->file_pdf_piutang)) {
                Storage::disk('public')->delete($customer->file_pdf_piutang);
            }

            $filePath = $request->file('file_pdf')->store('piutang', 'public');

            // UPDATE TANPA updated_at
            DB::table('m_customer')
                ->where('customer_id', $customerId)
                ->update([
                    'file_pdf_piutang' => $filePath,
                ]);

            return back()->with('success', "File PDF berhasil diperbarui/diunggah!");
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }

    public function destroyUploadPdf($id)
    {
        $this->checkAccess();

        $customer = DB::table('m_customer')->where('customer_id', $id)->first();

        if ($customer && !empty($customer->file_pdf_piutang)) {
            Storage::disk('public')->delete($customer->file_pdf_piutang);

            // UPDATE TANPA updated_at
            DB::table('m_customer')
                ->where('customer_id', $id)
                ->update([
                    'file_pdf_piutang' => null,
                ]);

            return back()->with('success', "File PDF piutang berhasil dihapus.");
        }

        return back()->with('error', "File PDF tidak ditemukan.");
    }

    public function previewPdf($id)
{
    $this->checkAccess();

    $customer = DB::table('m_customer')->where('customer_id', $id)->first();

    if (!$customer || empty($customer->file_pdf_piutang)) {
        abort(404, 'File tidak ditemukan.');
    }

    $path = storage_path('app/public/' . $customer->file_pdf_piutang);

    if (!file_exists($path)) {
        abort(404, 'File fisik tidak ditemukan di server.');
    }

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
    ]);
}
}