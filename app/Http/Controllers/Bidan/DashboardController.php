<?php

namespace App\Http\Controllers\Bidan;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\PemeriksaanAwalIbuHamil;
use App\Models\PemeriksaanAwalBalita;
use App\Models\PemeriksaanLanjutanIbuHamil;
use App\Models\PemeriksaanLanjutanBalita;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();
        $tgl     = Carbon::parse($tanggal);

        // Menunggu = belum ada pemeriksaan lanjutan (tidak tergantung tanggal)
        $menungguIbu    = PemeriksaanAwalIbuHamil::doesntHave('pemeriksaanLanjutan')->count();
        $menungguBalita = PemeriksaanAwalBalita::doesntHave('pemeriksaanLanjutan')->count();
        $totalMenunggu  = $menungguIbu + $menungguBalita;

        // Selesai = pemeriksaan lanjutan di tanggal yang dipilih
        $selesaiIbu    = PemeriksaanLanjutanIbuHamil::whereDate('tanggal_periksa', $tgl)->count();
        $selesaiBalita = PemeriksaanLanjutanBalita::whereDate('tanggal_periksa', $tgl)->count();
        $totalSelesai  = $selesaiIbu + $selesaiBalita;

        $pemeriksaanBulanIni =
            PemeriksaanLanjutanIbuHamil::whereMonth('tanggal_periksa', $tgl->month)
                ->whereYear('tanggal_periksa', $tgl->year)->count()
            + PemeriksaanLanjutanBalita::whereMonth('tanggal_periksa', $tgl->month)
                ->whereYear('tanggal_periksa', $tgl->year)->count();

        // Chart ikut bulan dari tanggal yang dipilih
        $chartLabels = $chartIbu = $chartBalita = [];
        for ($i = 5; $i >= 0; $i--) {
            $b = $tgl->copy()->startOfMonth()->subMonths($i);
            $chartLabels[] = $b->translatedFormat('M Y');
            $chartIbu[]    = PemeriksaanLanjutanIbuHamil::whereMonth('tanggal_periksa', $b->month)
                                ->whereYear('tanggal_periksa', $b->year)->count();
            $chartBalita[] = PemeriksaanLanjutanBalita::whereMonth('tanggal_periksa', $b->month)
                                ->whereYear('tanggal_periksa', $b->year)->count();
        }

        // Trimester ikut bulan dari tanggal yang dipilih
        $trimesterData = PemeriksaanLanjutanIbuHamil::join(
                'pemeriksaan_awal_ibu_hamil',
                'pemeriksaan_lanjutan_ibu_hamil.pemeriksaan_awal_id',
                '=',
                'pemeriksaan_awal_ibu_hamil.id'
            )
            ->selectRaw('
                CASE
                    WHEN pemeriksaan_awal_ibu_hamil.usia_kehamilan <= 12 THEN "I"
                    WHEN pemeriksaan_awal_ibu_hamil.usia_kehamilan <= 27 THEN "II"
                    ELSE "III"
                END as trimester,
                count(*) as total
            ')
            ->whereMonth('pemeriksaan_lanjutan_ibu_hamil.tanggal_periksa', $tgl->month)
            ->whereYear('pemeriksaan_lanjutan_ibu_hamil.tanggal_periksa', $tgl->year)
            ->groupBy('trimester')
            ->pluck('total', 'trimester');

        $trimesterI   = $trimesterData['I']   ?? 0;
        $trimesterII  = $trimesterData['II']  ?? 0;
        $trimesterIII = $trimesterData['III'] ?? 0;

        // Antrian filter per tanggal yang dipilih
        $antrianIbu = PemeriksaanAwalIbuHamil::with(['ibuHamil', 'kader', 'pemeriksaanLanjutan'])
            ->whereDate('tanggal_periksa', $tgl)
            ->orderByRaw('(SELECT COUNT(*) FROM pemeriksaan_lanjutan_ibu_hamil
                WHERE pemeriksaan_lanjutan_ibu_hamil.pemeriksaan_awal_id = pemeriksaan_awal_ibu_hamil.id) = 0 DESC')
            ->latest('tanggal_periksa')
            ->take(5)->get();

        $antrianBalita = PemeriksaanAwalBalita::with(['balita', 'kader', 'pemeriksaanLanjutan'])
            ->whereDate('tanggal_periksa', $tgl)
            ->orderByRaw('(SELECT COUNT(*) FROM pemeriksaan_lanjutan_balita
                WHERE pemeriksaan_lanjutan_balita.pemeriksaan_awal_id = pemeriksaan_awal_balita.id) = 0 DESC')
            ->latest('tanggal_periksa')
            ->take(5)->get();

        return view('bidan.dashboard', compact(
            'totalMenunggu', 'totalSelesai', 'pemeriksaanBulanIni',
            'antrianIbu', 'antrianBalita',
            'chartLabels', 'chartIbu', 'chartBalita',
            'trimesterI', 'trimesterII', 'trimesterIII',
            'tanggal'
        ));
    }
}