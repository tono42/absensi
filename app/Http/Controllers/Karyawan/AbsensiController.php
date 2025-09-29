<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $absensiHistory = Absensi::where('user_id', $user->id)
                                ->latest('tanggal')
                                ->paginate(10);

        return view('karyawan.absensi.index', compact('absensiHistory'));
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');

        // Cek apakah sudah ada data absensi hari ini
        $absensiToday = Absensi::where('user_id', $user->id)
                                ->whereDate('tanggal', $today)
                                ->first();

        if ($absensiToday && $absensiToday->check_in) {
            if (!$absensiToday->check_out) {
                return back()->with('warning', 'Anda sudah melakukan check-in hari ini.');
            }
            return back()->with('warning', 'Anda sudah melakukan check-in dan check-out hari ini.');
        }

        // Simpan foto kalau ada
        $fileName = null;
        if ($request->photo) {
            $image = $request->photo;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $fileName = 'absensi_' . $user->id . '_' . time() . '.png';
           Storage::disk('public')->put('absensi/' . $fileName, base64_decode($image));

        }

        // Buat absensi baru
        Absensi::create([
            'user_id'   => $user->id,
            'tanggal'   => $today,
            'check_in'  => $currentTime,
            'photo'     => $fileName,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'status'    => 'pending', // validasi admin
        ]);

        return back()->with('success', 'Check-in berhasil! Menunggu validasi admin.');
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');

        $absensiToday = Absensi::where('user_id', $user->id)
                            ->whereDate('tanggal', $today)
                            ->first();

        if (!$absensiToday) {
            return back()->with('error', 'Anda belum melakukan check-in hari ini.');
        }

        if ($absensiToday->check_out) {
            return back()->with('warning', 'Anda sudah melakukan check-out hari ini.');
        }

        $absensiToday->update([
            'check_out' => $currentTime,
        ]);

        return back()->with('success', 'Check-out berhasil!');
    }
}
