<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Izin;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    public function index(Request $request)
    {
        $izin = Izin::with('user')
                    ->when($request->status, function ($query) use ($request) {
                        $query->where('status', $request->status);
                    })
                    ->latest()
                    ->paginate(10);

        return view('admin.izin.index', compact('izin'));
    }

    public function validateIzin(Request $request, Izin $izin)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $izin->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Pengajuan izin berhasil divalidasi.');
    }

    // Method untuk menampilkan bukti
    public function showBukti(Izin $izin)
    {
        if ($izin->file_bukti && Storage::exists('public/' . $izin->file_bukti)) {
            return Storage::response('public/' . $izin->file_bukti);
        }
        abort(404, 'File bukti tidak ditemukan.');
    }
}