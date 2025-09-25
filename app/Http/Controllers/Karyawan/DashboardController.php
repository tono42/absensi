<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\Izin;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $absensiToday = Absensi::where('user_id', $user->id)
                            ->whereDate('tanggal', $today)
                            ->first();

        $riwayatAbsensi = Absensi::where('user_id', $user->id)
                                ->latest('tanggal')
                                ->take(5)
                                ->get();

        $pendingIzin = Izin::where('user_id', $user->id)
                            ->where('status', 'pending')
                            ->count();

        return view('karyawan.dashboard', compact('user', 'absensiToday', 'riwayatAbsensi', 'pendingIzin'));
    }
}