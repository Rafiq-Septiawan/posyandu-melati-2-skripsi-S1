<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\NotifikasiController;

// Auth routes (guest)
Route::get('/',           [LoginController::class, 'showLogin'])->name('login');
Route::get('/login',      [LoginController::class, 'showLogin']);
Route::post('/login',     [LoginController::class, 'login'])->name('login.process');
Route::post('/logout',    [LoginController::class, 'logout'])->name('logout');

// Registrasi khusus Orang Tua (guest)
Route::get('/register',   [LoginController::class, 'showRegister'])->name('register');
Route::post('/register',  [LoginController::class, 'register'])->name('register.process');

// Forgot/Reset Password
Route::get('/forgot-password',         [ForgotPasswordController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password',        [ForgotPasswordController::class, 'sendResetLink'])->name('password.forgot.send');
Route::get('/reset-password/{token}',  [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password',         [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.update');

// ===================== KETUA (Dahulu: admin) =====================
Route::prefix('ketua')
    ->name('ketua.')
    ->middleware(['auth', 'role:ketua'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Ketua\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/users', App\Http\Controllers\Ketua\UserController::class)
            ->parameters(['users' => 'user']);

        // Jadwal Posyandu (dikelola ketua)
        Route::resource('/jadwal-posyandu', App\Http\Controllers\JadwalPosyanduController::class)
            ->parameters(['jadwal-posyandu' => 'jadwal_posyandu']);
    });

// ===================== LAPORAN (Shared: ketua, kader, bidan) =====================
Route::prefix('ketua')
    ->name('ketua.')
    ->middleware(['auth', 'role:ketua,kader,bidan'])
    ->group(function () {
        Route::redirect('/laporan', '/ketua/laporan/ibu-hamil')->name('laporan.index');
        Route::get('/laporan/ibu-hamil',              [App\Http\Controllers\Ketua\LaporanController::class, 'laporanIbuHamil'])->name('laporan.ibu-hamil');
        Route::get('/laporan/ibu-hamil/{id}/detail',  [App\Http\Controllers\Ketua\LaporanController::class, 'detailIbuHamil'])->name('laporan.ibu-hamil.detail');
        Route::get('/laporan/ibu-hamil/export',       [App\Http\Controllers\Ketua\LaporanController::class, 'exportIbuHamil'])->name('laporan.ibu-hamil.export');
        Route::get('/laporan/balita',                 [App\Http\Controllers\Ketua\LaporanController::class, 'laporanBalita'])->name('laporan.balita');
        Route::get('/laporan/balita/{id}/detail',     [App\Http\Controllers\Ketua\LaporanController::class, 'detailBalita'])->name('laporan.balita.detail');
        Route::get('/laporan/balita/export',          [App\Http\Controllers\Ketua\LaporanController::class, 'exportBalita'])->name('laporan.balita.export');
    });

// ===================== KADER =====================
Route::prefix('kader')
    ->name('kader.')
    ->middleware(['auth', 'role:kader,ketua'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Kader\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/pemeriksaan-awal-balita', App\Http\Controllers\Kader\PemeriksaanAwalBalitaController::class)
            ->parameters(['pemeriksaan-awal-balita' => 'pemeriksaan_awal_balita']);

        Route::resource('/pemeriksaan-awal-ibu-hamil', App\Http\Controllers\Kader\PemeriksaanAwalIbuHamilController::class)
            ->parameters(['pemeriksaan-awal-ibu-hamil' => 'pemeriksaan_awal_ibu_hamil']);
    });

// ===================== BIDAN =====================
Route::prefix('bidan')
    ->name('bidan.')
    ->middleware(['auth', 'role:bidan,ketua'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Bidan\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/pemeriksaan-lanjutan-balita', App\Http\Controllers\Bidan\PemeriksaanLanjutanBalitaController::class)
            ->parameters(['pemeriksaan-lanjutan-balita' => 'pemeriksaan_lanjutan_balita']);

        Route::resource('/pemeriksaan-lanjutan-ibu-hamil', App\Http\Controllers\Bidan\PemeriksaanLanjutanIbuHamilController::class)
            ->parameters(['pemeriksaan-lanjutan-ibu-hamil' => 'pemeriksaan_lanjutan_ibu_hamil']);
    });

// ===================== ORANG TUA =====================
Route::prefix('orang-tua')
    ->name('orang-tua.')
    ->middleware(['auth', 'role:orang_tua'])
    ->group(function () {
        Route::get('/dashboard',  [App\Http\Controllers\OrangTua\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/riwayat-ibu-hamil',  [App\Http\Controllers\OrangTua\RiwayatController::class, 'ibuHamil'])->name('riwayat.ibu-hamil');
        Route::get('/riwayat-balita',     [App\Http\Controllers\OrangTua\RiwayatController::class, 'balita'])->name('riwayat.balita');
    });

// ===================== KETUA + KADER (Shared) =====================
Route::middleware(['auth', 'role:ketua,kader'])->group(function () {
    Route::resource('/ibu-hamil', App\Http\Controllers\IbuHamilController::class)
        ->parameters(['ibu-hamil' => 'ibu_hamil']);
    Route::resource('/balita', App\Http\Controllers\BalitaController::class)
        ->parameters(['balita' => 'balita']);
});

// ===================== SEMUA YANG SUDAH LOGIN =====================
Route::middleware(['auth'])->group(function () {
    Route::get('/notifikasi',   [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.mark-all-read');
    Route::get('/kalender',     fn() => view('layouts.kalender'))->name('kalender');
    Route::get('/search',       [NotifikasiController::class, 'search'])->name('search.global');
    Route::get('/jadwal-posyandu/public', [App\Http\Controllers\JadwalPosyanduController::class, 'publicIndex'])->name('jadwal-posyandu.public');
});