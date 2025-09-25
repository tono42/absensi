<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\IzinController as AdminIzinController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\AbsensiController as KaryawanAbsensiController;
use App\Http\Controllers\Karyawan\IzinController as KaryawanIzinController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('karyawan', KaryawanController::class); // Untuk CRUD karyawan
    Route::get('absensi', [AdminAbsensiController::class, 'index'])->name('absensi.index');
    Route::post('absensi/{absensi}/validate', [AdminAbsensiController::class, 'validateAbsensi'])->name('absensi.validate');
    Route::get('izin', [AdminIzinController::class, 'index'])->name('izin.index');
    Route::post('izin/{izin}/validate', [AdminIzinController::class, 'validateIzin'])->name('izin.validate');
});

// Karyawan Routes
Route::middleware(['auth', 'verified', 'karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');
    Route::get('/absensi', [KaryawanAbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/check-in', [KaryawanAbsensiController::class, 'checkIn'])->name('absensi.checkIn');
    Route::post('/absensi/check-out', [KaryawanAbsensiController::class, 'checkOut'])->name('absensi.checkOut');
    Route::resource('izin', KaryawanIzinController::class); // Untuk pengajuan izin
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirect user based on role after login
    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('karyawan.dashboard');
    })->name('dashboard');
    Route::get('/karyawan/absensi/export', [AbsensiController::class, 'export'])
    ->name('karyawan.absensi.export');
});

require __DIR__.'/auth.php';