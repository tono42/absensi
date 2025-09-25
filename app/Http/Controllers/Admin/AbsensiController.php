<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $absensi = Absensi::with('user')
                    ->when($request->tanggal, function ($query) use ($request) {
                        $query->whereDate('tanggal', $request->tanggal);
                    })
                    ->when($request->status, function ($query) use ($request) {
                        $query->where('status', $request->status);
                    })
                    ->latest()
                    ->paginate(10);

        return view('admin.absensi.index', compact('absensi'));
    }

    public function validateAbsensi(Request $request, Absensi $absensi)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $absensi->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Absensi berhasil divalidasi.');
    }
}