<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\IbuHamil;
use App\Models\Balita;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Riwayat pemeriksaan ibu hamil milik orang tua yang login
     */
    public function ibuHamil()
    {
        $user = Auth::user();

        $ibuHamil = IbuHamil::where('user_id', $user->id)
            ->with(['pemeriksaanAwal.kader', 'pemeriksaanLanjutan.bidan'])
            ->latest()
            ->first();

        return view('orang-tua.riwayat-ibu-hamil', compact('ibuHamil'));
    }

    /**
     * Riwayat pemeriksaan balita milik orang tua yang login
     */
    public function balita()
    {
        $user = Auth::user();

        $ibuHamil = IbuHamil::where('user_id', $user->id)->first();

        $balitas = $ibuHamil
            ? Balita::where('ibu_hamil_id', $ibuHamil->id)
                ->with(['pemeriksaanAwal.kader', 'pemeriksaanLanjutan.bidan'])
                ->get()
            : collect();

        return view('orang-tua.riwayat-balita', compact('balitas', 'ibuHamil'));
    }
}
