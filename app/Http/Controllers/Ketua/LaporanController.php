<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\IbuHamil;
use App\Models\Balita;
use App\Exports\LaporanIbuHamilExport;
use App\Exports\LaporanBalitaExport;
use App\Models\PemeriksaanAwalIbuHamil;
use App\Models\PemeriksaanAwalBalita;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanController extends Controller
{

    public function laporanIbuHamil(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $query = PemeriksaanAwalIbuHamil::with(['ibuHamil', 'kader', 'pemeriksaanLanjutan'])
                    ->whereMonth('tanggal_periksa', $bulan)
                    ->whereYear('tanggal_periksa', $tahun);

        if ($request->filled('search')) {
            $query->whereHas('ibuHamil', fn($q) =>
                $q->where('nama_ibu', 'like', '%' . $request->search . '%')
            );
        }

        $pemeriksaans     = $query->latest('tanggal_periksa')->paginate(15)->withQueryString();
        $totalPemeriksaan = PemeriksaanAwalIbuHamil::whereMonth('tanggal_periksa', $bulan)
                                ->whereYear('tanggal_periksa', $tahun)->count();
        $sudahDitangani   = \App\Models\PemeriksaanLanjutanIbuHamil::whereMonth('tanggal_periksa', $bulan)
                                ->whereYear('tanggal_periksa', $tahun)->count();

        $stats = [
            'total'   => $totalPemeriksaan,
            'normal'  => $sudahDitangani,
            'rujukan' => max(0, $totalPemeriksaan - $sudahDitangani),
        ];

        return view('ketua.laporan.ibu-hamil', compact('pemeriksaans', 'stats', 'bulan', 'tahun'));
    }

    public function detailIbuHamil($id)
    {
        $ibu = IbuHamil::with([
            'pemeriksaanAwal.kader',
            'pemeriksaanAwal.pemeriksaanLanjutan.bidan',
        ])->findOrFail($id);

        $riwayat = $ibu->pemeriksaanAwal()
            ->with(['kader', 'pemeriksaanLanjutan.bidan'])
            ->latest('tanggal_periksa')->get();

        return view('ketua.laporan.detail-laporan-ibu-hamil', compact('ibu', 'riwayat'));
    }

    public function exportIbuHamil(Request $request)
    {
        $bulan     = $request->get('bulan', now()->month);
        $tahun     = $request->get('tahun', now()->year);
        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->translatedFormat('F_Y');

        return Excel::download(
            new LaporanIbuHamilExport($bulan, $tahun, $request->get('search')),
            'Laporan_Ibu_Hamil_' . $namaBulan . '.xlsx'
        );
    }

    public function laporanBalita(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $query = PemeriksaanAwalBalita::with(['balita.ibuHamil', 'kader', 'pemeriksaanLanjutan'])
                    ->whereMonth('tanggal_periksa', $bulan)
                    ->whereYear('tanggal_periksa', $tahun);

        if ($request->filled('search')) {
            $query->whereHas('balita', fn($q) =>
                $q->where('nama_balita', 'like', '%' . $request->search . '%')
            );
        }

        $pemeriksaans = $query->latest('tanggal_periksa')->paginate(15)->withQueryString();
        $allData      = (clone $query)->get();

        $giziNormal = $giziKurang = $giziBuruk = 0;
        foreach ($allData as $p) {
            $sg = strtolower($p->pemeriksaanLanjutan->status_gizi ?? '');
            if (str_contains($sg, 'normal') || str_contains($sg, 'baik')) $giziNormal++;
            elseif (str_contains($sg, 'kurang'))                           $giziKurang++;
            elseif (str_contains($sg, 'buruk') || str_contains($sg, 'stunting')) $giziBuruk++;
        }

        $stats = [
            'total'       => $allData->count(),
            'gizi_normal' => $giziNormal,
            'gizi_kurang' => $giziKurang,
            'gizi_buruk'  => $giziBuruk,
        ];

        return view('ketua.laporan.balita', compact('pemeriksaans', 'stats', 'bulan', 'tahun'));
    }

    public function exportBalita(Request $request)
    {
        $bulan     = $request->get('bulan', now()->month);
        $tahun     = $request->get('tahun', now()->year);
        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->translatedFormat('F_Y');

        return Excel::download(
            new LaporanBalitaExport($bulan, $tahun, $request->get('search')),
            'Laporan_Balita_' . $namaBulan . '.xlsx'
        );
    }

    public function detailBalita($id)
    {
        $balita = \App\Models\Balita::with([
            'ibuHamil',
            'pemeriksaanAwal.kader',
            'pemeriksaanAwal.pemeriksaanLanjutan.bidan',
        ])->findOrFail($id);

        $riwayat = $balita->pemeriksaanAwal()
            ->with(['kader', 'pemeriksaanLanjutan.bidan'])
            ->latest('tanggal_periksa')
            ->get();

        return view('ketua.laporan.detail-laporan-balita', compact('balita', 'riwayat'));
    }
}
