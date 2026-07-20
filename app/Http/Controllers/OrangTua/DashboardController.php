<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\IbuHamil;
use App\Models\Balita;
use App\Models\JadwalPosyandu;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data ibu hamil yang terhubung dengan akun ini
        $ibuHamil = IbuHamil::where('user_id', $user->id)->latest()->first();

        // Ambil daftar balita melalui ibu_hamil yang terhubung
        $balitas = $ibuHamil
            ? Balita::where('ibu_hamil_id', $ibuHamil->id)->get()
            : collect();

        // Jadwal posyandu mendatang
        $jadwalMendatang = JadwalPosyandu::where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->take(3)
            ->get();

        return view('orang-tua.dashboard', compact('user', 'ibuHamil', 'balitas', 'jadwalMendatang'));
    }
}
