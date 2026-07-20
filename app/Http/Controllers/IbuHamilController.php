<?php

namespace App\Http\Controllers;

use App\Models\IbuHamil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IbuHamilController extends Controller
{
    public function index(Request $request)
    {
        $sessionKey = 'filter.ibu_hamil';

        if ($request->boolean('reset')) {
            $request->session()->forget($sessionKey);
            return redirect()->route('ibu-hamil.index', ['tanggal' => now()->toDateString()]);
        }

        if (!$request->hasAny(['tanggal', 'search', 'sort', 'tab'])) {
            $saved = $request->session()->get($sessionKey);
            return redirect()->route('ibu-hamil.index', $saved ?: ['tanggal' => now()->toDateString()])
                ->with(array_filter(session()->only(['success', 'error'])));
        }

        $request->session()->put($sessionKey, array_filter(
            $request->only(['tanggal', 'search', 'sort', 'tab']),
            fn($v) => $v !== null && $v !== ''
        ));

        $tab   = $request->input('tab'); // 'semua' | 'belum' | 'sudah' | null
        $isTab = in_array($tab, ['semua', 'belum', 'sudah']);

        $query = IbuHamil::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_ibu', 'like', "%$s%")
                    ->orWhere('nik',     'like', "%$s%")
                    ->orWhere('no_hp',   'like', "%$s%");
            });
        }

        // Hanya terapkan filter tanggal jika BUKAN mode tab
        if (!$isTab) {
            if ($request->filled('tanggal')) {
                $query->whereDate('created_at', $request->tanggal);
            }
        }

        if ($tab === 'belum') {
            $query->doesntHave('pemeriksaanAwal');
        } elseif ($tab === 'sudah') {
            $query->has('pemeriksaanAwal');
        }

        match ($request->sort) {
            'nama_asc'  => $query->orderBy('nama_ibu', 'asc'),
            'nama_desc' => $query->orderBy('nama_ibu', 'desc'),
            'hpht_baru' => $query->orderBy('hpht', 'desc'),
            'hpht_lama' => $query->orderBy('hpht', 'asc'),
            default     => $query->latest(),
        };

        $ibuHamils         = $query->paginate(10)->withQueryString();
        $totalSemua        = IbuHamil::count();
        $totalBelumPeriksa = IbuHamil::doesntHave('pemeriksaanAwal')->count();
        $totalSudahPeriksa = IbuHamil::has('pemeriksaanAwal')->count();
        return view('ibu-hamil.index', compact('ibuHamils', 'totalSemua', 'totalBelumPeriksa', 'totalSudahPeriksa'));
    }

    public function create()
    {
        $orangTuaList = \App\Models\User::where('role', 'orang_tua')->orderBy('nama')->get();
        return view('ibu-hamil.create', compact('orangTuaList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ibu'      => 'required|string|max:100',
            'nik'           => [
                'required',
                'numeric',
                'digits:16',
                function ($attribute, $value, $fail) {
                    if (\DB::table('ibu_hamil')->where('nik', $value)->exists()) {
                        $fail('NIK sudah terdaftar atau digunakan.');
                        return;
                    }
                    if (\DB::table('balita')->where('nik', $value)->exists()) {
                        $fail('NIK sudah terdaftar atau digunakan.');
                        return;
                    }
                }
            ],
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'nullable|string|max:255',
            'no_hp'         => 'nullable|string|max:15',
            'gravida'       => 'required|integer|min:1',
            'partus'        => 'required|integer|min:0',
            'abortus'       => 'required|integer|min:0',
            'hpht'          => 'required|date',
        ], [
            'nama_ibu.required'      => 'Nama ibu wajib diisi.',
            'nik.required'           => 'NIK wajib diisi.',
            'nik.numeric'            => 'NIK harus berupa angka.',
            'nik.digits'             => 'NIK harus 16 digit.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'hpht.required'          => 'HPHT wajib diisi.',
        ]);

        IbuHamil::create([
            'user_id'       => $request->user_id ?: null,
            'nama_ibu'      => $request->nama_ibu,
            'nik'           => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->no_hp,
            'gravida'       => $request->gravida,
            'partus'        => $request->partus,
            'abortus'       => $request->abortus,
            'hpht'          => $request->hpht,
            'created_by'    => Auth::id(),
        ]);

        return redirect()->route('ibu-hamil.index')->with('success', 'Data ibu hamil berhasil ditambahkan.');
    }

    public function show(IbuHamil $ibuHamil)
    {
        $ibuHamil->load(['pemeriksaanAwal.kader', 'pemeriksaanLanjutan.bidan', 'createdBy', 'updatedBy']);
        return view('ibu-hamil.show', compact('ibuHamil'));
    }

    public function edit(IbuHamil $ibuHamil)
    {
        $orangTuaList = \App\Models\User::where('role', 'orang_tua')->orderBy('nama')->get();
        return view('ibu-hamil.edit', compact('ibuHamil', 'orangTuaList'));
    }

    public function update(Request $request, IbuHamil $ibuHamil)
    {
        $id = $ibuHamil->id;
        $request->validate([
            'nama_ibu'      => 'required|string|max:100',
            'nik'           => [
                'required',
                'numeric',
                'digits:16',
                function ($attribute, $value, $fail) use ($id) {
                    if (\DB::table('ibu_hamil')->where('nik', $value)->where('id', '!=', $id)->exists()) {
                        $fail('NIK sudah terdaftar atau digunakan.');
                        return;
                    }
                    if (\DB::table('balita')->where('nik', $value)->exists()) {
                        $fail('NIK sudah terdaftar atau digunakan.');
                        return;
                    }
                }
            ],
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'nullable|string|max:255',
            'no_hp'         => 'nullable|string|max:15',
            'gravida'       => 'required|integer|min:1',
            'partus'        => 'required|integer|min:0',
            'abortus'       => 'required|integer|min:0',
            'hpht'          => 'required|date',
        ], [
            'nama_ibu.required'      => 'Nama ibu wajib diisi.',
            'nama_ibu.max'           => 'Nama ibu maksimal 100 karakter.',
            'nik.required'           => 'NIK wajib diisi.',
            'nik.numeric'            => 'NIK harus berupa angka.',
            'nik.digits'             => 'NIK harus terdiri dari 16 digit.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'alamat.max'             => 'Alamat maksimal 255 karakter.',
            'no_hp.max'              => 'Nomor HP maksimal 15 karakter.',
            'gravida.required'       => 'Gravida (G) wajib diisi.',
            'gravida.integer'        => 'Gravida harus berupa angka.',
            'gravida.min'            => 'Gravida minimal bernilai 1.',
            'partus.required'        => 'Partus (P) wajib diisi.',
            'partus.integer'         => 'Partus harus berupa angka.',
            'partus.min'             => 'Partus tidak boleh bernilai negatif.',
            'abortus.required'       => 'Abortus (A) wajib diisi.',
            'abortus.integer'        => 'Abortus harus berupa angka.',
            'abortus.min'            => 'Abortus tidak boleh bernilai negatif.',
            'hpht.required'          => 'HPHT wajib diisi.',
            'hpht.date'              => 'Format HPHT tidak valid.',
        ]);
        
        $ibuHamil->update([
            'user_id'       => $request->user_id ?: $ibuHamil->user_id,
            'nama_ibu'      => $request->nama_ibu,
            'nik'           => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->no_hp,
            'gravida'       => $request->gravida,
            'partus'        => $request->partus,
            'abortus'       => $request->abortus,
            'hpht'          => $request->hpht,
            'updated_by'    => Auth::id(),
        ]);

        return redirect()->route('ibu-hamil.index')->with('success', 'Data ibu hamil berhasil diperbarui.');
    }

    public function destroy(IbuHamil $ibuHamil)
    {
        $ibuHamil->delete();
        return redirect()->route('ibu-hamil.index')->with('success', 'Data ibu hamil berhasil dihapus.');
    }
}
