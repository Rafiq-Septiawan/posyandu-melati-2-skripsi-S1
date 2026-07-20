<?php

namespace App\Http\Controllers\Kader;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\IbuHamil;
use App\Models\Balita;
use App\Models\PemeriksaanAwalBalita;
use App\Models\PemeriksaanAwalIbuHamil;
use App\Models\PemeriksaanLanjutanIbuHamil;
use App\Models\PemeriksaanLanjutanBalita;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();
        $tgl     = Carbon::parse($tanggal);

        $totalIbuHamil = IbuHamil::count();
        $totalBalita   = Balita::count();

        $ibuSudahDiperiksa = PemeriksaanAwalIbuHamil::whereMonth('tanggal_periksa', $tgl->month)
            ->whereYear('tanggal_periksa', $tgl->year)
            ->distinct('ibu_hamil_id')->count('ibu_hamil_id');

        $balitaSudahDiperiksa = PemeriksaanAwalBalita::whereMonth('tanggal_periksa', $tgl->month)
            ->whereYear('tanggal_periksa', $tgl->year)
            ->distinct('balita_id')->count('balita_id');

        $ibuBelumDiperiksa = IbuHamil::whereDoesntHave('pemeriksaanAwal', fn($q) =>
            $q->whereMonth('tanggal_periksa', $tgl->month)
              ->whereYear('tanggal_periksa', $tgl->year))->get();

        $balitaBelumDiperiksa = Balita::whereDoesntHave('pemeriksaanAwal', fn($q) =>
            $q->whereMonth('tanggal_periksa', $tgl->month)
              ->whereYear('tanggal_periksa', $tgl->year))->get();

        $pemeriksaanHariIni = PemeriksaanAwalIbuHamil::whereDate('tanggal_periksa', $tgl)->count()
                            + PemeriksaanAwalBalita::whereDate('tanggal_periksa', $tgl)->count();

        $chartLabels = $chartIbu = $chartBalita = [];
        for ($i = 5; $i >= 0; $i--) {
            $b = $tgl->copy()->startOfMonth()->subMonths($i);
            $chartLabels[] = $b->translatedFormat('M Y');
            $chartIbu[]    = PemeriksaanAwalIbuHamil::whereMonth('tanggal_periksa', $b->month)
                                ->whereYear('tanggal_periksa', $b->year)->count();
            $chartBalita[] = PemeriksaanAwalBalita::whereMonth('tanggal_periksa', $b->month)
                                ->whereYear('tanggal_periksa', $b->year)->count();
        }

        $giziNormal = PemeriksaanLanjutanBalita::where('status_gizi', 'Baik')->count();
        $giziKurang = PemeriksaanLanjutanBalita::where('status_gizi', 'Gizi Kurang')->count();
        $giziBuruk  = PemeriksaanLanjutanBalita::where('status_gizi', 'Risiko Stunting')->count();
        $giziLebih  = PemeriksaanLanjutanBalita::where('status_gizi', 'Gizi Lebih')->count();

        $pemeriksaanIbu = PemeriksaanAwalIbuHamil::with(['ibuHamil', 'kader', 'pemeriksaanLanjutan'])
            ->whereDate('tanggal_periksa', $tgl)
            ->orderByRaw('(SELECT COUNT(*) FROM pemeriksaan_lanjutan_ibu_hamil
                WHERE pemeriksaan_lanjutan_ibu_hamil.pemeriksaan_awal_id = pemeriksaan_awal_ibu_hamil.id) = 0 DESC')
            ->latest('tanggal_periksa')
            ->take(10)->get()
            ->map(function ($item) {
                $item->status = $item->pemeriksaanLanjutan ? 'Selesai' : 'Menunggu Bidan';
                return $item;
            });

        $pemeriksaanBalita = PemeriksaanAwalBalita::with(['balita', 'kader', 'pemeriksaanLanjutan'])
            ->whereDate('tanggal_periksa', $tgl)
            ->orderByRaw('(SELECT COUNT(*) FROM pemeriksaan_lanjutan_balita
                WHERE pemeriksaan_lanjutan_balita.pemeriksaan_awal_id = pemeriksaan_awal_balita.id) = 0 DESC')
            ->latest('tanggal_periksa')
            ->take(10)->get();

        return view('kader.dashboard', compact(
            'totalIbuHamil', 'totalBalita',
            'ibuSudahDiperiksa', 'balitaSudahDiperiksa',
            'ibuBelumDiperiksa', 'balitaBelumDiperiksa',
            'pemeriksaanHariIni',
            'chartLabels', 'chartIbu', 'chartBalita',
            'giziNormal', 'giziKurang', 'giziBuruk', 'giziLebih',
            'pemeriksaanIbu', 'pemeriksaanBalita',
            'tanggal'
        ));
    }
}