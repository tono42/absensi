<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = User::where('role', 'karyawan')->count();
        $pendingAbsensi = Absensi::where('status', 'pending')->count();
        $pendingIzin = Izin::where('status', 'pending')->count();

        // Ambil absensi terbaru yang perlu divalidasi
        $absensiToValidate = Absensi::with('user')
                            ->where('status', 'pending')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact('totalKaryawan', 'pendingAbsensi', 'pendingIzin', 'absensiToValidate'));
    }
}