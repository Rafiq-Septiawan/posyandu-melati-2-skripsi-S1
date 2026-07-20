<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\IbuHamil;
use App\Models\Balita;
use App\Models\User;
use App\Models\PemeriksaanAwalIbuHamil;
use App\Models\PemeriksaanAwalBalita;
use App\Models\PemeriksaanLanjutanBalita;
use App\Models\PemeriksaanLanjutanIbuHamil;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();
        $tgl     = Carbon::parse($tanggal);

        $totalIbuHamil = IbuHamil::count();
        $totalBalita   = Balita::count();
        $totalUser     = User::count();

        $pemeriksaanBulanIni = PemeriksaanAwalIbuHamil::whereMonth('tanggal_periksa', $tgl->month)
                                ->whereYear('tanggal_periksa', $tgl->year)->count()
                             + PemeriksaanAwalBalita::whereMonth('tanggal_periksa', $tgl->month)
                                ->whereYear('tanggal_periksa', $tgl->year)->count();

        $pemeriksaanHariIni = PemeriksaanAwalIbuHamil::whereDate('tanggal_periksa', $tgl)->count()
                            + PemeriksaanAwalBalita::whereDate('tanggal_periksa', $tgl)->count();

        $pemeriksaanIbu = PemeriksaanAwalIbuHamil::with(['ibuHamil', 'kader'])
            ->whereDate('tanggal_periksa', $tgl)
            ->latest('tanggal_periksa')->take(5)->get()
            ->map(function($p) {
                $lanjutan = PemeriksaanLanjutanIbuHamil::where('pemeriksaan_awal_id', $p->id)
                    ->latest('tanggal_periksa')->first();
                return (object)[
                    'nama'      => $p->ibuHamil->nama_ibu ?? '-',
                    'usia'      => ($p->usia_kehamilan ?? '-') . ' minggu',
                    'jenis'     => 'ibu_hamil',
                    'tanggal'   => $p->tanggal_periksa,
                    'pemeriksa' => $p->kader->nama ?? '-',
                    'bidan'     => $lanjutan?->bidan?->nama ?? null,
                    'status'    => 'selesai',
                ];
            });

        $pemeriksaanBalita = PemeriksaanAwalBalita::with(['balita', 'kader'])
            ->whereDate('tanggal_periksa', $tgl)
            ->latest('tanggal_periksa')->take(5)->get()
            ->map(function($p) {
                $lanjutan = PemeriksaanLanjutanBalita::where('pemeriksaan_awal_id', $p->id)
                    ->latest('tanggal_periksa')->first();
                return (object)[
                    'nama'      => $p->balita->nama_balita ?? '-',
                    'usia'      => ($p->usia_balita ?? '-') . ' bulan',
                    'jenis'     => 'balita',
                    'tanggal'   => $p->tanggal_periksa,
                    'pemeriksa' => $p->kader->nama ?? '-',
                    'bidan'     => $lanjutan?->bidan?->nama ?? null,
                    'status'    => 'selesai',
                ];
            });

        $pemeriksaanTerbaru = $pemeriksaanIbu->concat($pemeriksaanBalita)
            ->sortByDesc('tanggal')->take(10)->values();

        $chartLabels   = [];
        $chartIbuHamil = [];
        $chartBalita   = [];

        for ($i = 5; $i >= 0; $i--) {
            $b = $tgl->copy()->startOfMonth()->subMonths($i);
            $chartLabels[]   = $b->translatedFormat('M Y');
            $chartIbuHamil[] = PemeriksaanAwalIbuHamil::whereMonth('tanggal_periksa', $b->month)
                                ->whereYear('tanggal_periksa', $b->year)->count();
            $chartBalita[]   = PemeriksaanAwalBalita::whereMonth('tanggal_periksa', $b->month)
                                ->whereYear('tanggal_periksa', $b->year)->count();
        }

        $giziNormal = PemeriksaanLanjutanBalita::where('status_gizi', 'Gizi Baik')->count();
        $giziKurang = PemeriksaanLanjutanBalita::where('status_gizi', 'Gizi Kurang')->count();
        $giziBuruk  = PemeriksaanLanjutanBalita::where('status_gizi', 'Gizi Buruk')->count();
        $giziLebih  = PemeriksaanLanjutanBalita::where('status_gizi', 'Gizi Lebih')->count();

        $trimester1 = PemeriksaanAwalIbuHamil::whereBetween('usia_kehamilan', [1, 12])->count();
        $trimester2 = PemeriksaanAwalIbuHamil::whereBetween('usia_kehamilan', [13, 26])->count();
        $trimester3 = PemeriksaanAwalIbuHamil::where('usia_kehamilan', '>=', 27)->count();

        $ibuSudahBidan = PemeriksaanLanjutanIbuHamil::whereMonth('tanggal_periksa', $tgl->month)
                            ->whereYear('tanggal_periksa', $tgl->year)->count();
        $ibuBelumBidan = max(0, PemeriksaanAwalIbuHamil::whereMonth('tanggal_periksa', $tgl->month)
                            ->whereYear('tanggal_periksa', $tgl->year)->count() - $ibuSudahBidan);

        $balitaSudahBidan = PemeriksaanLanjutanBalita::whereMonth('tanggal_periksa', $tgl->month)
                            ->whereYear('tanggal_periksa', $tgl->year)->count();
        $balitaBelumBidan = max(0, PemeriksaanAwalBalita::whereMonth('tanggal_periksa', $tgl->month)
                            ->whereYear('tanggal_periksa', $tgl->year)->count() - $balitaSudahBidan);

        return view('ketua.dashboard', compact(
            'totalIbuHamil', 'totalBalita', 'totalUser',
            'pemeriksaanBulanIni', 'pemeriksaanHariIni',
            'pemeriksaanTerbaru',
            'chartLabels', 'chartIbuHamil', 'chartBalita',
            'giziNormal', 'giziKurang', 'giziBuruk', 'giziLebih',
            'trimester1', 'trimester2', 'trimester3',
            'ibuSudahBidan', 'ibuBelumBidan',
            'balitaSudahBidan', 'balitaBelumBidan',
            'tanggal'
        ));
    }
}
