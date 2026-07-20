<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanAwalIbuHamil;
use App\Models\IbuHamil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanAwalIbuHamilController extends Controller
{
    public function index(Request $request)
    {
        $sessionKey = 'filter.kader_paih';

        if ($request->boolean('reset')) {
            $request->session()->forget($sessionKey);
            return redirect()->route('kader.pemeriksaan-awal-ibu-hamil.index', [
                'tanggal' => now()->toDateString(),
            ]);
        }

        if (!$request->hasAny(['tanggal', 'search', 'periode'])) {
            $saved = session($sessionKey);
            return redirect()->route(
                'kader.pemeriksaan-awal-ibu-hamil.index',
                $saved ?: ['tanggal' => now()->toDateString()]
            );
        }

        session([$sessionKey => array_filter(
            $request->only(['tanggal', 'search', 'periode']),
            fn($v) => $v !== null && $v !== ''
        )]);

        $query = PemeriksaanAwalIbuHamil::with(['ibuHamil'])
            ->latest('tanggal_periksa');

        if ($request->filled('search')) {
            $query->whereHas('ibuHamil', function ($q) use ($request) {
                $q->where('nama_ibu', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_periksa', $request->tanggal);
        }

        $periode = $request->input('periode');
        if ($periode === 'hari_ini') {
            $query->whereDate('tanggal_periksa', now()->toDateString());
        } elseif ($periode === 'bulan_ini') {
            $query->whereMonth('tanggal_periksa', now()->month)
                  ->whereYear('tanggal_periksa', now()->year);
        }

        $pemeriksaans  = $query->paginate(10)->withQueryString();
        $totalSemua    = PemeriksaanAwalIbuHamil::count();
        $totalHariIni  = PemeriksaanAwalIbuHamil::whereDate('tanggal_periksa', now()->toDateString())->count();
        $totalBulanIni = PemeriksaanAwalIbuHamil::whereMonth('tanggal_periksa', now()->month)
                            ->whereYear('tanggal_periksa', now()->year)->count();
        return view('kader.pemeriksaan-awal-ibu-hamil.index', compact(
            'pemeriksaans', 'totalSemua', 'totalHariIni', 'totalBulanIni'
        ));
    }

    public function create(Request $request)
    {
        $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
        $selectedIbu = $request->ibu_hamil_id
            ? IbuHamil::find($request->ibu_hamil_id)
            : null;

        return view('kader.pemeriksaan-awal-ibu-hamil.create', compact('ibuHamils', 'selectedIbu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ibu_hamil_id'    => 'required|exists:ibu_hamil,id',
            'tanggal_periksa' => 'required|date|before_or_equal:today',
            'berat_badan'     => 'required|numeric|min:20|max:200',
            'tekanan_darah'   => 'required|string|max:20',
            'keluhan'         => 'nullable|string|max:255',
        ], [
            'ibu_hamil_id.required'           => 'Nama ibu hamil wajib dipilih.',
            'ibu_hamil_id.exists'             => 'Ibu hamil tidak ditemukan.',
            'tanggal_periksa.required'        => 'Tanggal pemeriksaan wajib diisi.',
            'tanggal_periksa.date'            => 'Format tanggal tidak valid.',
            'tanggal_periksa.before_or_equal' => 'Tanggal pemeriksaan tidak boleh di masa depan.',
            'berat_badan.required'            => 'Berat badan wajib diisi.',
            'berat_badan.numeric'             => 'Berat badan harus berupa angka.',
            'berat_badan.min'                 => 'Berat badan minimal 20 kg.',
            'berat_badan.max'                 => 'Berat badan maksimal 200 kg.',
            'tekanan_darah.required'          => 'Tekanan darah wajib diisi.',
            'keluhan.max'                     => 'Maksimal 255 karakter.',
        ]);

        $ibu = IbuHamil::findOrFail($request->ibu_hamil_id);
        $usiaKehamilan = $ibu->hpht
            ? \Carbon\Carbon::parse($ibu->hpht)->diffInWeeks($request->tanggal_periksa)
            : null;

        PemeriksaanAwalIbuHamil::create([
            'ibu_hamil_id'    => $request->ibu_hamil_id,
            'kader_id'        => Auth::id(),
            'tanggal_periksa' => $request->tanggal_periksa,
            'usia_kehamilan'  => $usiaKehamilan,
            'berat_badan'     => $request->berat_badan,
            'tekanan_darah'   => $request->tekanan_darah,
            'keluhan'         => $request->keluhan,
        ]);

        return redirect()->route('kader.pemeriksaan-awal-ibu-hamil.index', [
            'tanggal' => $request->tanggal_periksa,
        ])->with('success', 'Data pemeriksaan awal ibu hamil berhasil disimpan.');
    }

    public function show(PemeriksaanAwalIbuHamil $pemeriksaanAwalIbuHamil)
    {
        $pemeriksaanAwalIbuHamil->load(['ibuHamil', 'kader', 'updatedBy']);
        return view('kader.pemeriksaan-awal-ibu-hamil.show', [
            'pem' => $pemeriksaanAwalIbuHamil,
        ]);
    }

    public function edit(PemeriksaanAwalIbuHamil $pemeriksaanAwalIbuHamil)
    {
        $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
        return view('kader.pemeriksaan-awal-ibu-hamil.edit', [
            'pem'       => $pemeriksaanAwalIbuHamil,
            'ibuHamils' => $ibuHamils,
        ]);
    }

    public function update(Request $request, PemeriksaanAwalIbuHamil $pemeriksaanAwalIbuHamil)
    {
        $request->validate([
            'ibu_hamil_id'    => 'required|exists:ibu_hamil,id',
            'tanggal_periksa' => 'required|date|before_or_equal:today',
            'berat_badan'     => 'required|numeric|min:20|max:200',
            'tekanan_darah'   => 'required|string|max:20',
            'keluhan'         => 'nullable|string|max:255',
        ], [
            'ibu_hamil_id.required'           => 'Nama ibu hamil wajib dipilih.',
            'ibu_hamil_id.exists'             => 'Ibu hamil tidak ditemukan.',
            'tanggal_periksa.required'        => 'Tanggal pemeriksaan wajib diisi.',
            'tanggal_periksa.date'            => 'Format tanggal tidak valid.',
            'tanggal_periksa.before_or_equal' => 'Tanggal pemeriksaan tidak boleh di masa depan.',
            'berat_badan.required'            => 'Berat badan wajib diisi.',
            'berat_badan.numeric'             => 'Berat badan harus berupa angka.',
            'berat_badan.min'                 => 'Berat badan minimal 20 kg.',
            'berat_badan.max'                 => 'Berat badan maksimal 200 kg.',
            'tekanan_darah.required'          => 'Tekanan darah wajib diisi.',
            'keluhan.max'                     => 'Maksimal 255 karakter.',
        ]);

        $ibu = IbuHamil::findOrFail($request->ibu_hamil_id);
        $usiaKehamilan = $ibu->hpht
            ? \Carbon\Carbon::parse($ibu->hpht)->diffInWeeks($request->tanggal_periksa)
            : null;

        $pemeriksaanAwalIbuHamil->update([
            'ibu_hamil_id'    => $request->ibu_hamil_id,
            'updated_by'      => Auth::id(),
            'tanggal_periksa' => $request->tanggal_periksa,
            'usia_kehamilan'  => $usiaKehamilan,
            'berat_badan'     => $request->berat_badan,
            'tekanan_darah'   => $request->tekanan_darah,
            'keluhan'         => $request->keluhan,
        ]);

        return redirect()->route('kader.pemeriksaan-awal-ibu-hamil.index', [
            'tanggal' => $request->tanggal_periksa,
        ])->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroy(PemeriksaanAwalIbuHamil $pemeriksaanAwalIbuHamil)
    {
        $tanggal = $pemeriksaanAwalIbuHamil->tanggal_periksa;
        $pemeriksaanAwalIbuHamil->delete();

        return redirect()->route('kader.pemeriksaan-awal-ibu-hamil.index', [
            'tanggal' => $tanggal,
        ])->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
}