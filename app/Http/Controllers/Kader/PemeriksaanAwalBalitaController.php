<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanAwalBalita;
use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class PemeriksaanAwalBalitaController extends Controller
{
    // ─────────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $sessionKey = 'filter.kader_pab';

        if ($request->boolean('reset')) {
            $request->session()->forget($sessionKey);
            return redirect()->route('kader.pemeriksaan-awal-balita.index', [
                'tanggal' => now()->toDateString(),
            ])->with('info', 'Filter berhasil direset.');
        }

        if (!$request->hasAny(['tanggal', 'search', 'periode'])) {
            $saved = $request->session()->get($sessionKey);
            return redirect()->route('kader.pemeriksaan-awal-balita.index',
                $saved ?: ['tanggal' => now()->toDateString()]
            );
        }

        $request->session()->put($sessionKey, array_filter(
            $request->only(['tanggal', 'search', 'periode']),
            fn($v) => $v !== null && $v !== ''
        ));

        try {
            $query = PemeriksaanAwalBalita::with(['balita'])->latest('tanggal_periksa');

            if ($request->filled('search')) {
                $query->whereHas('balita', fn($q) =>
                    $q->where('nama_balita', 'like', '%'.$request->search.'%')
                );
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

            $pemeriksaans   = $query->paginate(10)->withQueryString();
            $totalSemua     = PemeriksaanAwalBalita::count();
            $totalHariIni   = PemeriksaanAwalBalita::whereDate('tanggal_periksa', now()->toDateString())->count();
            $totalBulanIni  = PemeriksaanAwalBalita::whereMonth('tanggal_periksa', now()->month)
                                ->whereYear('tanggal_periksa', now()->year)->count();

            return view('kader.pemeriksaan-awal-balita.index', compact(
                'pemeriksaans', 'totalSemua', 'totalHariIni', 'totalBulanIni'
            ));

        } catch (Throwable $e) {
            Log::error('Gagal memuat data pemeriksaan awal balita: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->route('kader.pemeriksaan-awal-balita.index', ['tanggal' => now()->toDateString()])
                ->with('error', 'Terjadi kesalahan saat memuat data pemeriksaan. Silakan coba lagi.');
        }
    }

    // ─────────────────────────────────────────────
    //  CREATE
    // ─────────────────────────────────────────────
    public function create(Request $request)
    {
        try {
            $balitas        = Balita::with('ibuHamil')->orderBy('nama_balita')->get();
            $selectedBalita = $request->balita_id ? Balita::with('ibuHamil')->find($request->balita_id) : null;

            return view('kader.pemeriksaan-awal-balita.create', compact('balitas', 'selectedBalita'));

        } catch (Throwable $e) {
            Log::error('Gagal memuat halaman catat pemeriksaan balita: ' . $e->getMessage());

            return redirect()
                ->route('kader.pemeriksaan-awal-balita.index')
                ->with('error', 'Halaman catat pemeriksaan tidak dapat dibuka. Silakan coba lagi.');
        }
    }

    // ─────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────
    public function store(Request $request)
    {
        try {
            $request->validate([
                'balita_id'       => 'required|exists:balita,id',
                'tanggal_periksa' => 'required|date|before_or_equal:today',
                'berat_badan'     => 'required|numeric|min:0.5|max:50',
                'tinggi_badan'    => 'required|numeric|min:20|max:150',
                'lingkar_kepala'  => 'required|numeric|min:20|max:80',
                'lingkar_lengan'  => 'required|numeric|min:5|max:40',
                'keluhan'         => 'nullable|string|max:255',
            ], [
                'balita_id.required'              => 'Nama balita wajib dipilih.',
                'balita_id.exists'                => 'Balita yang dipilih tidak ditemukan dalam sistem.',
                'tanggal_periksa.required'        => 'Tanggal pemeriksaan wajib diisi.',
                'tanggal_periksa.date'            => 'Format tanggal pemeriksaan tidak valid.',
                'tanggal_periksa.before_or_equal' => 'Tanggal pemeriksaan tidak boleh di masa depan.',
                'berat_badan.required'            => 'Berat badan wajib diisi.',
                'berat_badan.numeric'             => 'Berat badan harus berupa angka.',
                'berat_badan.min'                 => 'Berat badan minimal 0,5 kg.',
                'berat_badan.max'                 => 'Berat badan maksimal 50 kg.',
                'tinggi_badan.required'           => 'Tinggi/panjang badan wajib diisi.',
                'tinggi_badan.numeric'            => 'Tinggi/panjang badan harus berupa angka.',
                'tinggi_badan.min'                => 'Tinggi/panjang badan minimal 20 cm.',
                'tinggi_badan.max'                => 'Tinggi/panjang badan maksimal 150 cm.',
                'lingkar_kepala.required'         => 'Lingkar kepala wajib diisi.',
                'lingkar_kepala.numeric'          => 'Lingkar kepala harus berupa angka.',
                'lingkar_kepala.min'              => 'Lingkar kepala minimal 20 cm.',
                'lingkar_kepala.max'              => 'Lingkar kepala maksimal 80 cm.',
                'lingkar_lengan.required'         => 'Lingkar lengan wajib diisi.',
                'lingkar_lengan.numeric'          => 'Lingkar lengan harus berupa angka.',
                'lingkar_lengan.min'              => 'Lingkar lengan minimal 5 cm.',
                'lingkar_lengan.max'              => 'Lingkar lengan maksimal 40 cm.',
                'keluhan.max'                     => 'Maksimal 255 karakter.',
            ]);

            $balita    = Balita::findOrFail($request->balita_id);
            $usiaBulan = (int)\Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths($request->tanggal_periksa);

            PemeriksaanAwalBalita::create([
                'balita_id'       => $request->balita_id,
                'kader_id'        => Auth::id(),
                'tanggal_periksa' => $request->tanggal_periksa,
                'usia_balita'     => $usiaBulan,
                'berat_badan'     => $request->berat_badan,
                'tinggi_badan'    => $request->tinggi_badan,
                'lingkar_kepala'  => $request->lingkar_kepala,
                'lingkar_lengan'  => $request->lingkar_lengan,
                'keluhan'         => $request->keluhan,
            ]);

            return redirect()->route('kader.pemeriksaan-awal-balita.index', [
                'tanggal' => $request->tanggal_periksa,
            ])->with('success', 'Data pemeriksaan awal balita atas nama "' . $balita->nama_balita . '" berhasil disimpan.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (Throwable $e) {
            Log::error('Gagal menyimpan pemeriksaan awal balita: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'input'   => $request->except(['_token']),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat menyimpan data. Silakan coba lagi atau hubungi administrator.');
        }
    }

    // ─────────────────────────────────────────────
    //  SHOW
    // ─────────────────────────────────────────────
    public function show(PemeriksaanAwalBalita $pemeriksaanAwalBalita)
    {
        try {
            $pemeriksaanAwalBalita->load(['balita.ibuHamil', 'kader', 'updatedBy']);

            return view('kader.pemeriksaan-awal-balita.show', ['pem' => $pemeriksaanAwalBalita]);

        } catch (Throwable $e) {
            Log::error('Gagal memuat detail pemeriksaan balita ID ' . $pemeriksaanAwalBalita->id . ': ' . $e->getMessage());

            return redirect()
                ->route('kader.pemeriksaan-awal-balita.index')
                ->with('error', 'Data pemeriksaan tidak dapat ditampilkan. Silakan coba lagi.');
        }
    }

    // ─────────────────────────────────────────────
    //  EDIT
    // ─────────────────────────────────────────────
    public function edit(PemeriksaanAwalBalita $pemeriksaanAwalBalita)
    {
        try {
            $balitas = Balita::with('ibuHamil')->orderBy('nama_balita')->get();

            return view('kader.pemeriksaan-awal-balita.edit', [
                'pem'     => $pemeriksaanAwalBalita,
                'balitas' => $balitas,
            ]);

        } catch (Throwable $e) {
            Log::error('Gagal memuat halaman edit pemeriksaan balita ID ' . $pemeriksaanAwalBalita->id . ': ' . $e->getMessage());

            return redirect()
                ->route('kader.pemeriksaan-awal-balita.index')
                ->with('error', 'Halaman edit pemeriksaan tidak dapat dibuka. Silakan coba lagi.');
        }
    }

    // ─────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────
    public function update(Request $request, PemeriksaanAwalBalita $pemeriksaanAwalBalita)
    {
        try {
            $request->validate([
                'balita_id'       => 'required|exists:balita,id',
                'tanggal_periksa' => 'required|date|before_or_equal:today',
                'berat_badan'     => 'required|numeric|min:0.5|max:50',
                'tinggi_badan'    => 'required|numeric|min:20|max:150',
                'lingkar_kepala'  => 'required|numeric|min:20|max:80',
                'lingkar_lengan'  => 'required|numeric|min:5|max:40',
                'keluhan'         => 'nullable|string|max:255',
            ], [
                'balita_id.required'              => 'Nama balita wajib dipilih.',
                'balita_id.exists'                => 'Balita yang dipilih tidak ditemukan dalam sistem.',
                'tanggal_periksa.required'        => 'Tanggal pemeriksaan wajib diisi.',
                'tanggal_periksa.date'            => 'Format tanggal pemeriksaan tidak valid.',
                'tanggal_periksa.before_or_equal' => 'Tanggal pemeriksaan tidak boleh di masa depan.',
                'berat_badan.required'            => 'Berat badan wajib diisi.',
                'berat_badan.numeric'             => 'Berat badan harus berupa angka.',
                'berat_badan.min'                 => 'Berat badan minimal 0,5 kg.',
                'berat_badan.max'                 => 'Berat badan maksimal 50 kg.',
                'tinggi_badan.required'           => 'Tinggi/panjang badan wajib diisi.',
                'tinggi_badan.numeric'            => 'Tinggi/panjang badan harus berupa angka.',
                'tinggi_badan.min'                => 'Tinggi/panjang badan minimal 20 cm.',
                'tinggi_badan.max'                => 'Tinggi/panjang badan maksimal 150 cm.',
                'lingkar_kepala.required'         => 'Lingkar kepala wajib diisi.',
                'lingkar_kepala.numeric'          => 'Lingkar kepala harus berupa angka.',
                'lingkar_kepala.min'              => 'Lingkar kepala minimal 20 cm.',
                'lingkar_kepala.max'              => 'Lingkar kepala maksimal 80 cm.',
                'lingkar_lengan.required'         => 'Lingkar lengan wajib diisi.',
                'lingkar_lengan.numeric'          => 'Lingkar lengan harus berupa angka.',
                'lingkar_lengan.min'              => 'Lingkar lengan minimal 5 cm.',
                'lingkar_lengan.max'              => 'Lingkar lengan maksimal 40 cm.',
                'keluhan.max'                     => 'Maksimal 255 karakter.',
            ]);

            $balita    = Balita::findOrFail($request->balita_id);
            $usiaBulan = (int)\Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths($request->tanggal_periksa);

            $pemeriksaanAwalBalita->update([
                'balita_id'       => $request->balita_id,
                'updated_by'      => Auth::id(),
                'tanggal_periksa' => $request->tanggal_periksa,
                'usia_balita'     => $usiaBulan,
                'berat_badan'     => $request->berat_badan,
                'tinggi_badan'    => $request->tinggi_badan,
                'lingkar_kepala'  => $request->lingkar_kepala,
                'lingkar_lengan'  => $request->lingkar_lengan,
                'keluhan'         => $request->keluhan,
            ]);

            return redirect()->route('kader.pemeriksaan-awal-balita.index', [
                'tanggal' => $request->tanggal_periksa,
            ])->with('success', 'Data pemeriksaan atas nama "' . $balita->nama_balita . '" berhasil diperbarui.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (Throwable $e) {
            Log::error('Gagal memperbarui pemeriksaan awal balita ID ' . $pemeriksaanAwalBalita->id . ': ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'input'   => $request->except(['_token', '_method']),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat memperbarui data. Silakan coba lagi atau hubungi administrator.');
        }
    }

    // ─────────────────────────────────────────────
    //  DESTROY
    // ─────────────────────────────────────────────
    public function destroy(PemeriksaanAwalBalita $pemeriksaanAwalBalita)
    {
        try {
            $tanggal     = $pemeriksaanAwalBalita->tanggal_periksa;
            $namaBalita  = $pemeriksaanAwalBalita->balita->nama_balita ?? 'balita';
            $pemeriksaanAwalBalita->delete();

            return redirect()->route('kader.pemeriksaan-awal-balita.index', [
                'tanggal' => $tanggal,
            ])->with('success', 'Data pemeriksaan atas nama "' . $namaBalita . '" berhasil dihapus.');

        } catch (Throwable $e) {
            Log::error('Gagal menghapus pemeriksaan awal balita ID ' . $pemeriksaanAwalBalita->id . ': ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->route('kader.pemeriksaan-awal-balita.index')
                ->with('error', 'Data pemeriksaan tidak dapat dihapus. Mungkin masih ada data terkait yang harus dihapus terlebih dahulu.');
        }
    }
}