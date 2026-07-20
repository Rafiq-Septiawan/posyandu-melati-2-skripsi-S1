<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BalitaController extends Controller
{
    public function index(Request $request)
    {
        $sessionKey = 'filter.balita';

        if ($request->boolean('reset')) {
            Session::forget($sessionKey);
            return redirect()->route('balita.index', ['tanggal' => now()->toDateString()]);
        }

        if (!$request->hasAny(['tanggal', 'search', 'sort', 'tab'])) {
            $saved = Session::get($sessionKey);
            return redirect()->route('balita.index', $saved ?: ['tanggal' => now()->toDateString()])
                ->with(array_filter(session()->only(['success', 'error'])));
        }

        Session::put($sessionKey, array_filter(
            $request->only(['tanggal', 'search', 'sort', 'tab']),
            fn($v) => $v !== null && $v !== ''
        ));

        $tab   = $request->input('tab');
        $isTab = in_array($tab, ['semua', 'L', 'P']);

        $query = Balita::with('ibuHamil');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_balita', 'like', "%$s%")
                    ->orWhere('nik', 'like', "%$s%")
                    ->orWhereHas('ibuHamil', fn($ih) => $ih->where('nama_ibu', 'like', "%$s%"));
            });
        }

        if (!$isTab) {
            $filterDate = $request->filled('tanggal')
                ? $request->tanggal
                : now()->format('Y-m-d');
            $query->whereDate('created_at', $filterDate);
        }

        if ($tab === 'L') {
            $query->where('jenis_kelamin', 'L');
        } elseif ($tab === 'P') {
            $query->where('jenis_kelamin', 'P');
        }

        match ($request->sort) {
            'nama_asc'  => $query->orderBy('nama_balita', 'asc'),
            'nama_desc' => $query->orderBy('nama_balita', 'desc'),
            'tgl_baru'  => $query->orderBy('tanggal_lahir', 'desc'),
            'tgl_lama'  => $query->orderBy('tanggal_lahir', 'asc'),
            default     => $query->latest(),
        };

        $balitas        = $query->paginate(10)->withQueryString();
        $totalSemua     = Balita::count();
        $totalLakiLaki  = Balita::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Balita::where('jenis_kelamin', 'P')->count();
        return view('balita.index', compact('balitas', 'totalSemua', 'totalLakiLaki', 'totalPerempuan'));
    }

    public function create()
    {
        $ibuHamils = \App\Models\IbuHamil::all();
        return view('balita.create', compact('ibuHamils'));
    }

    public function store(Request $request)
    {
        $ibuHamilId = $request->input('ibu_hamil_id');

        $request->validate([
            'ibu_hamil_id'  => 'required|exists:ibu_hamil,id',
            'nama_balita'   => 'required|string|max:100',
            'nik'           => [
                'nullable',
                'numeric',
                'digits:16',
                function ($attribute, $value, $fail) {
                    if ($value && \DB::table('balita')->where('nik', $value)->exists()) {
                        $fail('NIK sudah terdaftar atau digunakan.');
                        return;
                    }
                    if ($value && \DB::table('ibu_hamil')->where('nik', $value)->exists()) {
                        $fail('NIK sudah terdaftar atau digunakan.');
                        return;
                    }
                }
            ],
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'ibu_hamil_id.required'  => 'Ibu hamil wajib dipilih.',
            'ibu_hamil_id.exists'    => 'Data ibu hamil tidak valid.',
            'nama_balita.required'   => 'Nama balita wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'nik.numeric'            => 'NIK harus berupa angka.',
            'nik.digits'             => 'NIK harus 16 digit.',
        ]);

        Balita::create([
            'ibu_hamil_id'  => $request->ibu_hamil_id,
            'nama_balita'   => $request->nama_balita,
            'nik'           => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'created_by'    => Auth::id(),
        ]);

        return redirect()->route('balita.index')
            ->with('success', 'Data balita berhasil ditambahkan.');
    }

    public function show(Balita $balita)
    {
        $balita->load(['ibuHamil', 'pemeriksaanAwal.kader', 'pemeriksaanLanjutan.pemeriksaanAwal', 'createdBy', 'updatedBy']);
        return view('balita.show', compact('balita'));
    }

    public function edit(Balita $balita)
    {
        $ibuHamils = \App\Models\IbuHamil::all();
        return view('balita.edit', compact('balita', 'ibuHamils'));
    }

    public function update(Request $request, Balita $balita)
    {
        $section = $request->input('_section', 'balita');

        $id = $balita->id;
        if ($section === 'balita') {
            $request->validate([
                'nama_balita'   => 'required|string|max:100',
                'nik'           => [
                    'nullable',
                    'numeric',
                    'digits:16',
                    function ($attribute, $value, $fail) use ($id) {
                        if ($value && \DB::table('balita')->where('nik', $value)->where('id', '!=', $id)->exists()) {
                            $fail('NIK sudah terdaftar atau digunakan.');
                            return;
                        }
                        if ($value && \DB::table('ibu_hamil')->where('nik', $value)->exists()) {
                            $fail('NIK sudah terdaftar atau digunakan.');
                            return;
                        }
                    }
                ],
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:L,P',
                'ibu_hamil_id'  => 'required|exists:ibu_hamil,id',
            ], [
                'nama_balita.required'   => 'Nama balita wajib diisi.',
                'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                'nik.numeric'            => 'NIK harus berupa angka.',
                'nik.digits'             => 'NIK harus 16 digit.',
                'ibu_hamil_id.required'  => 'Ibu hamil wajib dipilih.',
            ]);
        }

        if ($section === 'balita') {
            $balita->update([
                'nama_balita'   => $request->nama_balita,
                'nik'           => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'ibu_hamil_id'  => $request->ibu_hamil_id,
                'updated_by'    => Auth::id(),
            ]);
        }

        return redirect()->route('balita.index')
            ->with('success', 'Data balita berhasil diperbarui.');
    }

    public function destroy(Balita $balita)
    {
        $balita->delete();
        return redirect()->route('balita.index')
            ->with('success', 'Data balita berhasil dihapus.');
    }
}
