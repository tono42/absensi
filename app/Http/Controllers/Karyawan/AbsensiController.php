<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
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

    public function checkIn()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');

        $absensiToday = Absensi::firstOrCreate(
            ['user_id' => $user->id, 'tanggal' => $today],
            ['check_in' => $currentTime, 'status' => 'pending'] // Set pending untuk validasi admin
        );

        if ($absensiToday->wasRecentlyCreated) {
            return back()->with('success', 'Check-in berhasil! Menunggu validasi admin.');
        } else if ($absensiToday->check_in && !$absensiToday->check_out) {
            return back()->with('warning', 'Anda sudah melakukan check-in hari ini.');
        } else if ($absensiToday->check_in && $absensiToday->check_out) {
             return back()->with('warning', 'Anda sudah melakukan check-in dan check-out hari ini.');
        }
         return back()->with('error', 'Terjadi kesalahan saat check-in.');
    }

    public function checkOut()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');

        $absensiToday = Absensi::where('user_id', $user->id)
                            ->whereDate('tanggal', $today)
                            ->first();

        if ($absensiToday && $absensiToday->check_in && !$absensiToday->check_out) {
            $absensiToday->update(['check_out' => $currentTime]);
            return back()->with('success', 'Check-out berhasil!');
        } elseif (!$absensiToday) {
            return back()->with('error', 'Anda belum melakukan check-in hari ini.');
        } elseif ($absensiToday->check_out) {
            return back()->with('warning', 'Anda sudah melakukan check-out hari ini.');
        }

        return back()->with('error', 'Terjadi kesalahan saat check-out.');
    }
}