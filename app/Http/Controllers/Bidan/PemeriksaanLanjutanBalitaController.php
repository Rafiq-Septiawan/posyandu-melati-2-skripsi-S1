<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanLanjutanBalita;
use App\Models\PemeriksaanAwalBalita;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanLanjutanBalitaController extends Controller
{
    private function whoBBU(): array
    {
        return [
            'L' => [
                0==['median'=>3.346,'sd'=>0.430],1==['median'=>4.465,'sd'=>0.553],
                2==['median'=>5.574,'sd'=>0.647],3==['median'=>6.376,'sd'=>0.710],
                4==['median'=>7.010,'sd'=>0.757],5==['median'=>7.510,'sd'=>0.793],
                6==['median'=>7.934,'sd'=>0.820],7==['median'=>8.297,'sd'=>0.843],
                8==['median'=>8.600,'sd'=>0.863],9==['median'=>8.857,'sd'=>0.882],
                10==['median'=>9.080,'sd'=>0.899],11==['median'=>9.276,'sd'=>0.914],
                12==['median'=>9.453,'sd'=>0.928],13==['median'=>9.617,'sd'=>0.942],
                14==['median'=>9.771,'sd'=>0.956],15==['median'=>9.917,'sd'=>0.970],
                16==['median'=>10.058,'sd'=>0.983],17==['median'=>10.196,'sd'=>0.997],
                18==['median'=>10.332,'sd'=>1.010],19==['median'=>10.466,'sd'=>1.023],
                20==['median'=>10.600,'sd'=>1.037],21==['median'=>10.733,'sd'=>1.050],
                22==['median'=>10.866,'sd'=>1.064],23==['median'=>10.999,'sd'=>1.078],
                24==['median'=>11.134,'sd'=>1.092],25==['median'=>11.269,'sd'=>1.106],
                26==['median'=>11.404,'sd'=>1.120],27==['median'=>11.539,'sd'=>1.134],
                28==['median'=>11.674,'sd'=>1.148],29==['median'=>11.809,'sd'=>1.162],
                30==['median'=>11.944,'sd'=>1.176],31==['median'=>12.078,'sd'=>1.190],
                32==['median'=>12.212,'sd'=>1.204],33==['median'=>12.346,'sd'=>1.218],
                34==['median'=>12.479,'sd'=>1.231],35==['median'=>12.611,'sd'=>1.245],
                36==['median'=>12.743,'sd'=>1.258],37==['median'=>12.874,'sd'=>1.272],
                38==['median'=>13.004,'sd'=>1.285],39==['median'=>13.133,'sd'=>1.298],
                40==['median'=>13.261,'sd'=>1.311],41==['median'=>13.388,'sd'=>1.324],
                42==['median'=>13.514,'sd'=>1.337],43==['median'=>13.639,'sd'=>1.350],
                44==['median'=>13.762,'sd'=>1.362],45==['median'=>13.885,'sd'=>1.375],
                46==['median'=>14.006,'sd'=>1.387],47==['median'=>14.126,'sd'=>1.399],
                48==['median'=>14.245,'sd'=>1.411],49==['median'=>14.363,'sd'=>1.423],
                50==['median'=>14.480,'sd'=>1.435],51==['median'=>14.596,'sd'=>1.447],
                52==['median'=>14.710,'sd'=>1.458],53==['median'=>14.824,'sd'=>1.470],
                54==['median'=>14.936,'sd'=>1.481],55==['median'=>15.047,'sd'=>1.492],
                56==['median'=>15.157,'sd'=>1.503],57==['median'=>15.266,'sd'=>1.514],
                58==['median'=>15.373,'sd'=>1.525],59==['median'=>15.480,'sd'=>1.536],
                60==['median'=>15.586,'sd'=>1.547],
            ],
            'P' => [
                0==['median'=>3.232,'sd'=>0.397],1==['median'=>4.187,'sd'=>0.497],
                2==['median'=>5.130,'sd'=>0.580],3==['median'=>5.850,'sd'=>0.641],
                4==['median'=>6.423,'sd'=>0.689],5==['median'=>6.875,'sd'=>0.728],
                6==['median'=>7.268,'sd'=>0.760],7==['median'=>7.620,'sd'=>0.789],
                8==['median'=>7.934,'sd'=>0.814],9==['median'=>8.200,'sd'=>0.838],
                10==['median'=>8.452,'sd'=>0.860],11==['median'=>8.685,'sd'=>0.880],
                12==['median'=>8.900,'sd'=>0.900],13==['median'=>9.107,'sd'=>0.920],
                14==['median'=>9.306,'sd'=>0.939],15==['median'=>9.499,'sd'=>0.957],
                16==['median'=>9.686,'sd'=>0.975],17==['median'=>9.869,'sd'=>0.993],
                18==['median'=>10.048,'sd'=>1.011],19==['median'=>10.224,'sd'=>1.028],
                20==['median'=>10.397,'sd'=>1.046],21==['median'=>10.568,'sd'=>1.063],
                22==['median'=>10.737,'sd'=>1.080],23==['median'=>10.904,'sd'=>1.097],
                24==['median'=>11.070,'sd'=>1.114],25==['median'=>11.234,'sd'=>1.131],
                26==['median'=>11.397,'sd'=>1.148],27==['median'=>11.558,'sd'=>1.164],
                28==['median'=>11.718,'sd'=>1.181],29==['median'=>11.877,'sd'=>1.197],
                30==['median'=>12.034,'sd'=>1.213],31==['median'=>12.190,'sd'=>1.229],
                32==['median'=>12.345,'sd'=>1.245],33==['median'=>12.498,'sd'=>1.261],
                34==['median'=>12.650,'sd'=>1.276],35==['median'=>12.800,'sd'=>1.291],
                36==['median'=>12.949,'sd'=>1.307],37==['median'=>13.097,'sd'=>1.322],
                38==['median'=>13.243,'sd'=>1.337],39==['median'=>13.388,'sd'=>1.351],
                40==['median'=>13.531,'sd'=>1.366],41==['median'=>13.673,'sd'=>1.380],
                42==['median'=>13.814,'sd'=>1.394],43==['median'=>13.953,'sd'=>1.408],
                44==['median'=>14.091,'sd'=>1.422],45==['median'=>14.228,'sd'=>1.436],
                46==['median'=>14.363,'sd'=>1.449],47==['median'=>14.497,'sd'=>1.463],
                48==['median'=>14.630,'sd'=>1.476],49==['median'=>14.762,'sd'=>1.489],
                50==['median'=>14.892,'sd'=>1.502],51==['median'=>15.021,'sd'=>1.515],
                52==['median'=>15.149,'sd'=>1.528],53==['median'=>15.276,'sd'=>1.540],
                54==['median'=>15.401,'sd'=>1.553],55==['median'=>15.526,'sd'=>1.565],
                56==['median'=>15.649,'sd'=>1.578],57==['median'=>15.771,'sd'=>1.590],
                58==['median'=>15.892,'sd'=>1.602],59==['median'=>16.012,'sd'=>1.614],
                60==['median'=>16.130,'sd'=>1.626],
            ],
        ];
    }

    private function hitungStatusGizi(float $bb, int $usiaBulan, string $jk): string
    {
        $tabel  = $this->whoBBU();
        $bulan  = min(max($usiaBulan, 0), 60);
        $jkKey  = $jk === 'L' ? 'L' : 'P';
        $ref    = $tabel[$jkKey][$bulan] ?? null;
        if (!$ref) return 'baik';
        $zscore = ($bb - $ref['median']) / $ref['sd'];
        if ($zscore < -3) return 'buruk';
        if ($zscore < -2) return 'kurang';
        if ($zscore <= 2) return 'baik';
        return 'lebih';
    }

    public function index(Request $request)
    {
        $sessionKey = 'filter.bidan_plb';

        if ($request->boolean('reset')) {
            $request->session()->forget($sessionKey);
            return redirect()->route('bidan.pemeriksaan-lanjutan-balita.index', ['tanggal' => now()->toDateString()]);
        }

        if (!$request->hasAny(['tanggal', 'search', 'status'])) {
            $saved = $request->session()->get($sessionKey);
            return redirect()->route('bidan.pemeriksaan-lanjutan-balita.index', $saved ?: ['tanggal' => now()->toDateString()]);
        }

        $request->session()->put($sessionKey, array_filter(
            $request->only(['tanggal', 'search', 'status']),
            fn($v) => $v !== null && $v !== ''
        ));

        $query = PemeriksaanAwalBalita::with(['balita', 'kader', 'pemeriksaanLanjutan.bidan'])
            ->withCount('pemeriksaanLanjutan')
            ->orderBy('pemeriksaan_lanjutan_count', 'asc')
            ->latest('tanggal_periksa');

        if ($request->filled('search')) {
            $query->whereHas('balita', fn($q) => $q->where('nama_balita', 'like', '%'.$request->search.'%'));
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_periksa', $request->tanggal);
        }

        $status = $request->input('status');
        if ($status === 'belum') $query->doesntHave('pemeriksaanLanjutan');
        elseif ($status === 'sudah') $query->has('pemeriksaanLanjutan');

        $pemeriksaans  = $query->paginate(10)->withQueryString();
        $totalMenunggu = PemeriksaanAwalBalita::doesntHave('pemeriksaanLanjutan')->count();
        $totalSudah    = PemeriksaanAwalBalita::has('pemeriksaanLanjutan')->count();
        $totalSemua    = PemeriksaanAwalBalita::count();

        return view('bidan.pemeriksaan-lanjutan-balita.index', compact('pemeriksaans', 'totalMenunggu', 'totalSudah', 'totalSemua'));
    }

    public function create(Request $request)
    {
        $antrianList = PemeriksaanAwalBalita::with('balita')
            ->whereDoesntHave('pemeriksaanLanjutan', function ($q) {
                $q->whereMonth('tanggal_periksa', now()->month)->whereYear('tanggal_periksa', now()->year);
            })
            ->latest('tanggal_periksa')
            ->get();

        $selectedAwal = $request->pemeriksaan_awal_id
            ? PemeriksaanAwalBalita::with('balita')->find($request->pemeriksaan_awal_id)
            : null;

        return view('bidan.pemeriksaan-lanjutan-balita.create', compact('antrianList', 'selectedAwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemeriksaan_awal_id' => 'required|exists:pemeriksaan_awal_balita,id',
            'tanggal_periksa'     => 'required|date|before_or_equal:today',
            'status_gizi'         => 'required|in:Gizi Baik,Gizi Kurang,Gizi Buruk,Gizi Lebih',
            'imunisasi'           => 'nullable|string|max:500',
            'vitamin_a'           => 'required|in:diberikan,tidak_diberikan,belum_waktunya',
            'tindak_lanjut'       => 'required|in:kontrol,rujukan_puskesmas,rujukan_rs,rawat_inap',
            'catatan_bidan'       => 'nullable|string|max:255',
        ], [
            'pemeriksaan_awal_id.required' => 'Balita harus dipilih.',
            'tanggal_periksa.required'     => 'Tanggal pemeriksaan harus diisi.',
            'tanggal_periksa.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.',
            'status_gizi.required'         => 'Status gizi harus dipilih.',
            'vitamin_a.required'           => 'Vitamin A harus dipilih.',
            'tindak_lanjut.required'       => 'Tindak lanjut harus dipilih.',
            'catatan_bidan.max'            => 'Catatan bidan maksimal 255 karakter.',
        ]);

        $awal = PemeriksaanAwalBalita::with('balita')->findOrFail($request->pemeriksaan_awal_id);

        $sudahAda = PemeriksaanLanjutanBalita::where('balita_id', $awal->balita_id)
            ->whereMonth('tanggal_periksa', now()->month)
            ->whereYear('tanggal_periksa', now()->year)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Pemeriksaan lanjutan untuk balita ini di bulan ini sudah ada.')->withInput();
        }

        PemeriksaanLanjutanBalita::create([
            'balita_id'           => $awal->balita_id,
            'pemeriksaan_awal_id' => $awal->id,
            'bidan_id'            => Auth::id(),
            'created_by'          => Auth::id(),
            'updated_by'          => Auth::id(),
            'tanggal_periksa'     => $request->tanggal_periksa,
            'status_gizi'         => $request->status_gizi,
            'imunisasi'           => $request->imunisasi,
            'vitamin_a'           => $request->vitamin_a,
            'tindak_lanjut'       => $request->tindak_lanjut,
            'catatan_bidan'       => $request->catatan_bidan,
        ]);

        return redirect()->route('bidan.pemeriksaan-lanjutan-balita.index', [
            'tanggal' => Carbon::parse($request->tanggal_periksa)->format('Y-m-d'),
        ])->with('success', 'Pemeriksaan lanjutan balita berhasil disimpan.');
    }

    public function show(PemeriksaanLanjutanBalita $pemeriksaanLanjutanBalita)
    {
        $pemeriksaanLanjutanBalita->load([
            'pemeriksaanAwal.balita',
            'pemeriksaanAwal.kader',
            'bidan',
            'createdBy',
            'updatedBy',
        ]);
        return view('bidan.pemeriksaan-lanjutan-balita.show', ['pem' => $pemeriksaanLanjutanBalita]);
    }

    public function edit(PemeriksaanLanjutanBalita $pemeriksaanLanjutanBalita)
    {
        $pemeriksaanLanjutanBalita->load(['pemeriksaanAwal.balita', 'pemeriksaanAwal.kader']);
        return view('bidan.pemeriksaan-lanjutan-balita.edit', ['pem' => $pemeriksaanLanjutanBalita]);
    }

    public function update(Request $request, PemeriksaanLanjutanBalita $pemeriksaanLanjutanBalita)
    {
        $request->validate([
            'status_gizi'         => 'required|in:Gizi Baik,Gizi Kurang,Gizi Buruk,Gizi Lebih',
            'imunisasi'           => 'nullable|string|max:500',
            'vitamin_a'           => 'required|in:diberikan,tidak_diberikan,belum_waktunya',
            'tindak_lanjut'       => 'required|in:kontrol,rujukan_puskesmas,rujukan_rs,rawat_inap',
            'catatan_bidan'       => 'nullable|string|max:255',
        ], [
            'status_gizi.required'         => 'Status gizi harus dipilih.',
            'vitamin_a.required'           => 'Vitamin A harus dipilih.',
            'tindak_lanjut.required'       => 'Tindak lanjut harus dipilih.',
            'catatan_bidan.max'            => 'Catatan bidan maksimal 255 karakter.',
        ]);

        $pemeriksaanLanjutanBalita->update([
            'status_gizi'   => $request->status_gizi,
            'imunisasi'     => $request->imunisasi,
            'vitamin_a'     => $request->vitamin_a,
            'tindak_lanjut' => $request->tindak_lanjut,
            'catatan_bidan' => $request->catatan_bidan,
            'updated_by'    => Auth::id(),
        ]);

        return redirect()->route('bidan.pemeriksaan-lanjutan-balita.index', [
            'tanggal' => Carbon::parse($request->redirect_tanggal ?? $pemeriksaanLanjutanBalita->tanggal_periksa)->format('Y-m-d'),
        ])->with('success', 'Pemeriksaan lanjutan balita berhasil diperbarui.');
    }

    public function destroy(PemeriksaanLanjutanBalita $pemeriksaanLanjutanBalita)
    {
        $pemeriksaanLanjutanBalita->delete();
        return redirect()->route('bidan.pemeriksaan-lanjutan-balita.index', [
            'tanggal' => now()->format('Y-m-d'),
        ])->with('success', 'Data pemeriksaan lanjutan berhasil dihapus.');
    }
}