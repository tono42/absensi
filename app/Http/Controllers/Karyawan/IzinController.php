<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Izin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    public function index()
    {
        $izin = Izin::where('user_id', Auth::id())->latest()->paginate(10);
        return view('karyawan.izin.index', compact('izin'));
    }

    public function create()
    {
        return view('karyawan.izin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_izin' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'file_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        $filePath = null;
        if ($request->hasFile('file_bukti')) {
            $filePath = $request->file('file_bukti')->store('bukti_izin', 'public');
        }

        Izin::create([
            'user_id' => Auth::id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_izin' => $request->jenis_izin,
            'keterangan' => $request->keterangan,
            'file_bukti' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->route('karyawan.izin.index')->with('success', 'Pengajuan izin berhasil dikirim. Menunggu persetujuan admin.');
    }
}