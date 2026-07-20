<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanLanjutanIbuHamil;
use App\Models\PemeriksaanAwalIbuHamil;
use App\Models\IbuHamil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class PemeriksaanLanjutanIbuHamilController extends Controller
{
    public function index(Request $request)
    {
        $sessionKey = 'filter.bidan_plih';

        if ($request->boolean('reset')) {
            $request->session()->forget($sessionKey);
            return redirect()->route('bidan.pemeriksaan-lanjutan-ibu-hamil.index', [
                'tanggal' => now()->toDateString(),
            ])->with('info', 'Filter berhasil direset.');
        }

        if (!$request->hasAny(['tanggal', 'search', 'status'])) {
            $saved = $request->session()->get($sessionKey);
            return redirect()->route(
                'bidan.pemeriksaan-lanjutan-ibu-hamil.index',
                $saved ?: ['tanggal' => now()->toDateString()]
            );
        }

        $request->session()->put($sessionKey, array_filter(
            $request->only(['tanggal', 'search', 'status']),
            fn($v) => $v !== null && $v !== ''
        ));

        try {
            $query = PemeriksaanAwalIbuHamil::with([
                'ibuHamil', 'kader', 'pemeriksaanLanjutan.bidan',
            ])
                ->withCount('pemeriksaanLanjutan')
                ->orderByRaw('pemeriksaan_lanjutan_count = 0 DESC')
                ->latest('tanggal_periksa');

            if ($request->filled('search')) {
                $query->whereHas('ibuHamil', function ($q) use ($request) {
                    $q->where('nama_ibu', 'like', '%' . $request->search . '%');
                });
            }

            $status = $request->input('status');

            if ($request->filled('tanggal')) {
                $query->whereDate('tanggal_periksa', $request->tanggal);
            }

            if ($status === 'belum') {
                $query->doesntHave('pemeriksaanLanjutan');
            } elseif ($status === 'sudah') {
                $query->has('pemeriksaanLanjutan');
            }

            $pemeriksaans  = $query->paginate(10)->withQueryString();
            $totalMenunggu = PemeriksaanAwalIbuHamil::doesntHave('pemeriksaanLanjutan')->count();
            $totalSudah    = PemeriksaanAwalIbuHamil::has('pemeriksaanLanjutan')->count();
            $totalSemua    = PemeriksaanAwalIbuHamil::count();

            return view('bidan.pemeriksaan-lanjutan-ibu-hamil.index', compact(
                'pemeriksaans', 'totalMenunggu', 'totalSudah', 'totalSemua'
            ));

        } catch (Throwable $e) {
            Log::error('Gagal memuat data pemeriksaan lanjutan ibu hamil: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->route('bidan.pemeriksaan-lanjutan-ibu-hamil.index', ['tanggal' => now()->toDateString()])
                ->with('error', 'Terjadi kesalahan saat memuat data pemeriksaan. Silakan coba lagi.');
        }
    }

    public function create(Request $request)
    {
        try {
            $antrianList = PemeriksaanAwalIbuHamil::with(['ibuHamil', 'kader'])
                ->whereDoesntHave('pemeriksaanLanjutan', function ($q) {
                    $q->whereMonth('tanggal_periksa', now()->month)
                        ->whereYear('tanggal_periksa', now()->year);
                })
                ->latest('tanggal_periksa')
                ->get();

            $selectedAwal = $request->pemeriksaan_awal_id
                ? PemeriksaanAwalIbuHamil::with('ibuHamil')->find($request->pemeriksaan_awal_id)
                : null;

            return view('bidan.pemeriksaan-lanjutan-ibu-hamil.create', compact('antrianList', 'selectedAwal'));

        } catch (Throwable $e) {
            Log::error('Gagal memuat halaman catat pemeriksaan lanjutan: ' . $e->getMessage());

            return redirect()
                ->route('bidan.pemeriksaan-lanjutan-ibu-hamil.index')
                ->with('error', 'Halaman catat pemeriksaan lanjutan tidak dapat dibuka. Silakan coba lagi.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'pemeriksaan_awal_id' => 'required|exists:pemeriksaan_awal_ibu_hamil,id',
                'tanggal_periksa'     => 'required|date|before_or_equal:today',
                'lila'                => 'required|numeric|min:10|max:50',
                'tfu'                 => 'required|numeric|min:0|max:50',
                'djj'                 => 'nullable|integer|min:60|max:200',
                'catatan_bidan'       => 'nullable|string|max:255',
                'tindak_lanjut'       => 'required|in:kontrol,rujukan_puskesmas,rujukan_rs,rawat_inap',
            ], [
                'pemeriksaan_awal_id.required' => 'Data pemeriksaan kader wajib dipilih.',
                'pemeriksaan_awal_id.exists'   => 'Data pemeriksaan kader yang dipilih tidak ditemukan.',
                'tanggal_periksa.required'     => 'Tanggal pemeriksaan wajib diisi.',
                'tanggal_periksa.date'         => 'Format tanggal pemeriksaan tidak valid.',
                'tanggal_periksa.before_or_equal' => 'Tanggal pemeriksaan tidak boleh di masa depan.',
                'lila.required'                => 'Lingkar Lengan Atas (LILA) wajib diisi.',
                'lila.numeric'                 => 'LILA harus berupa angka.',
                'lila.min'                     => 'LILA minimal 10 cm.',
                'lila.max'                     => 'LILA maksimal 50 cm.',
                'tfu.required'                 => 'Tinggi Fundus Uteri (TFU) wajib diisi.',
                'tfu.numeric'                  => 'TFU harus berupa angka.',
                'tfu.min'                      => 'TFU tidak boleh bernilai negatif.',
                'tfu.max'                      => 'TFU maksimal 50 cm.',
                'djj.integer'                  => 'Detak Jantung Janin (DJJ) harus berupa angka bulat.',
                'djj.min'                      => 'DJJ minimal 60 bpm.',
                'djj.max'                      => 'DJJ maksimal 200 bpm.',
                'catatan_bidan.max'            => 'Catatan bidan maksimal 255 karakter.',
                'tindak_lanjut.required'       => 'Tindak lanjut wajib dipilih.',
                'tindak_lanjut.in'             => 'Pilihan tindak lanjut tidak valid.',
            ]);

            $pemeriksaanAwal = PemeriksaanAwalIbuHamil::findOrFail($request->pemeriksaan_awal_id);

            $sudahAda = PemeriksaanLanjutanIbuHamil::where('ibu_hamil_id', $pemeriksaanAwal->ibu_hamil_id)
                ->whereMonth('tanggal_periksa', now()->month)
                ->whereYear('tanggal_periksa', now()->year)
                ->exists();

            if ($sudahAda) {
                return back()
                    ->withInput()
                    ->with('error', 'Pemeriksaan lanjutan untuk ibu ini di bulan ' . now()->translatedFormat('F Y') . ' sudah tercatat.');
            }

            PemeriksaanLanjutanIbuHamil::create([
                'ibu_hamil_id'        => $pemeriksaanAwal->ibu_hamil_id,
                'bidan_id'            => Auth::id(),
                'pemeriksaan_awal_id' => $pemeriksaanAwal->id,
                'tanggal_periksa'     => $request->tanggal_periksa,
                'lila'                => $request->lila,
                'tfu'                 => $request->tfu,
                'djj'                 => $request->djj,
                'catatan_bidan'       => $request->catatan_bidan,
                'tindak_lanjut'       => $request->tindak_lanjut,
            ]);

            return redirect()
                ->route('bidan.pemeriksaan-lanjutan-ibu-hamil.index', [
                    'tanggal' => \Carbon\Carbon::parse($request->tanggal_periksa)->format('Y-m-d'),
                ])
                ->with('success', 'Pemeriksaan lanjutan ibu hamil atas nama "' . ($pemeriksaanAwal->ibuHamil->nama_ibu ?? 'ibu') . '" berhasil disimpan.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (Throwable $e) {
            Log::error('Gagal menyimpan pemeriksaan lanjutan ibu hamil: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'input'   => $request->except(['_token']),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat menyimpan data. Silakan coba lagi atau hubungi administrator.');
        }
    }

    public function show(PemeriksaanLanjutanIbuHamil $pemeriksaanLanjutanIbuHamil)
    {
        try {
            $pemeriksaanLanjutanIbuHamil->load(['ibuHamil', 'bidan', 'updatedBy', 'pemeriksaanAwal.kader']);

            return view('bidan.pemeriksaan-lanjutan-ibu-hamil.show', [
                'pem' => $pemeriksaanLanjutanIbuHamil,
            ]);

        } catch (Throwable $e) {
            Log::error('Gagal memuat detail pemeriksaan lanjutan ID ' . $pemeriksaanLanjutanIbuHamil->id . ': ' . $e->getMessage());

            return redirect()
                ->route('bidan.pemeriksaan-lanjutan-ibu-hamil.index')
                ->with('error', 'Data pemeriksaan lanjutan tidak dapat ditampilkan. Silakan coba lagi.');
        }
    }

    public function edit(PemeriksaanLanjutanIbuHamil $pemeriksaanLanjutanIbuHamil)
    {
        try {
            $pemeriksaanLanjutanIbuHamil->load(['ibuHamil', 'pemeriksaanAwal.kader']);

            return view('bidan.pemeriksaan-lanjutan-ibu-hamil.edit', [
                'pem' => $pemeriksaanLanjutanIbuHamil,
            ]);

        } catch (Throwable $e) {
            Log::error('Gagal memuat halaman edit pemeriksaan lanjutan ID ' . $pemeriksaanLanjutanIbuHamil->id . ': ' . $e->getMessage());

            return redirect()
                ->route('bidan.pemeriksaan-lanjutan-ibu-hamil.index')
                ->with('error', 'Halaman edit pemeriksaan lanjutan tidak dapat dibuka. Silakan coba lagi.');
        }
    }

    public function update(Request $request, PemeriksaanLanjutanIbuHamil $pemeriksaanLanjutanIbuHamil)
    {
        try {
            $request->validate([
                'tanggal_periksa' => 'required|date|before_or_equal:today',
                'lila'            => 'required|numeric|min:10|max:50',
                'tfu'             => 'required|numeric|min:0|max:50',
                'djj'             => 'nullable|integer|min:60|max:200',
                'catatan_bidan'   => 'nullable|string|max:255',
                'tindak_lanjut'   => 'required|in:kontrol,rujukan_puskesmas,rujukan_rs,rawat_inap',
            ], [
                'tanggal_periksa.required'        => 'Tanggal pemeriksaan wajib diisi.',
                'tanggal_periksa.date'            => 'Format tanggal pemeriksaan tidak valid.',
                'tanggal_periksa.before_or_equal' => 'Tanggal pemeriksaan tidak boleh di masa depan.',
                'lila.required'                   => 'Lingkar Lengan Atas (LILA) wajib diisi.',
                'lila.numeric'                    => 'LILA harus berupa angka.',
                'lila.min'                        => 'LILA minimal 10 cm.',
                'lila.max'                        => 'LILA maksimal 50 cm.',
                'tfu.required'                    => 'Tinggi Fundus Uteri (TFU) wajib diisi.',
                'tfu.numeric'                     => 'TFU harus berupa angka.',
                'tfu.min'                         => 'TFU tidak boleh bernilai negatif.',
                'tfu.max'                         => 'TFU maksimal 50 cm.',
                'djj.integer'                     => 'Detak Jantung Janin (DJJ) harus berupa angka bulat.',
                'djj.min'                         => 'DJJ minimal 60 bpm.',
                'djj.max'                         => 'DJJ maksimal 200 bpm.',
                'catatan_bidan.max'               => 'Catatan bidan maksimal 255 karakter.',
                'tindak_lanjut.required'          => 'Tindak lanjut wajib dipilih.',
                'tindak_lanjut.in'                => 'Pilihan tindak lanjut tidak valid.',
            ]);

            $pemeriksaanLanjutanIbuHamil->update([
                'tanggal_periksa' => $request->tanggal_periksa,
                'updated_by'      => Auth::id(),
                'lila'            => $request->lila,
                'tfu'             => $request->tfu,
                'djj'             => $request->djj,
                'catatan_bidan'   => $request->catatan_bidan,
                'tindak_lanjut'   => $request->tindak_lanjut,
            ]);

            return redirect()
                ->route('bidan.pemeriksaan-lanjutan-ibu-hamil.index', [
                    'tanggal' => \Carbon\Carbon::parse($request->tanggal_periksa)->format('Y-m-d'),
                ])
                ->with('success', 'Pemeriksaan lanjutan atas nama "' . ($pemeriksaanLanjutanIbuHamil->ibuHamil->nama_ibu ?? 'ibu') . '" berhasil diperbarui.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (Throwable $e) {
            Log::error('Gagal memperbarui pemeriksaan lanjutan ID ' . $pemeriksaanLanjutanIbuHamil->id . ': ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'input'   => $request->except(['_token', '_method']),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat memperbarui data. Silakan coba lagi atau hubungi administrator.');
        }
    }

    public function destroy(PemeriksaanLanjutanIbuHamil $pemeriksaanLanjutanIbuHamil)
    {
        try {
            $nama    = $pemeriksaanLanjutanIbuHamil->ibuHamil->nama_ibu ?? 'ibu';
            $tanggal = $pemeriksaanLanjutanIbuHamil->tanggal_periksa;
            $pemeriksaanLanjutanIbuHamil->delete();

            return redirect()
                ->route('bidan.pemeriksaan-lanjutan-ibu-hamil.index', [
                    'tanggal' => $tanggal,
                ])
                ->with('success', 'Data pemeriksaan lanjutan atas nama "' . $nama . '" berhasil dihapus.');

        } catch (Throwable $e) {
            Log::error('Gagal menghapus pemeriksaan lanjutan ID ' . $pemeriksaanLanjutanIbuHamil->id . ': ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->route('bidan.pemeriksaan-lanjutan-ibu-hamil.index')
                ->with('error', 'Data pemeriksaan lanjutan tidak dapat dihapus. Mungkin masih ada data terkait.');
        }
    }
}