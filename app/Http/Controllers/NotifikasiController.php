<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IbuHamil;
use App\Models\Balita;
use App\Models\PemeriksaanAwalIbuHamil;
use App\Models\PemeriksaanAwalBalita;

class NotifikasiController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $role = auth()->user()->role ?? '';

        // Count of unread notifications for badge
        $unreadCount = \App\Models\Notifikasi::where('user_id', $userId)
            ->where('is_read', 0)
            ->count();

        // Get latest 10 notifications
        $userNotifs = \App\Models\Notifikasi::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        $items = [];
        foreach ($userNotifs as $n) {
            $icon = 'fa-bell';
            $color = '#14a398';
            $bg = '#e6f7f6';

            if ($n->tipe === 'jadwal') {
                $icon = 'fa-calendar-days';
                $color = '#f59e0b';
                $bg = '#fef3e2';
            } elseif ($n->tipe === 'pemeriksaan') {
                $icon = 'fa-stethoscope';
                $color = '#6366f1';
                $bg = '#eef0ff';
            }

            // Determine navigation link based on role and tipe/content
            $link = '#';
            if ($role === 'orang_tua') {
                if ($n->tipe === 'jadwal') {
                    $link = route('jadwal-posyandu.public');
                } elseif ($n->tipe === 'pemeriksaan') {
                    if (str_contains(strtolower($n->judul), 'ibu') || str_contains(strtolower($n->pesan), 'ibu')) {
                        $link = route('orang-tua.riwayat.ibu-hamil');
                    } else {
                        $link = route('orang-tua.riwayat.balita');
                    }
                }
            } elseif ($role === 'ketua') {
                if ($n->tipe === 'jadwal') {
                    $link = route('ketua.jadwal-posyandu.index');
                } elseif ($n->tipe === 'pemeriksaan') {
                    if (str_contains(strtolower($n->judul), 'ibu') || str_contains(strtolower($n->pesan), 'ibu')) {
                        $link = route('ketua.laporan.ibu-hamil');
                    } else {
                        $link = route('ketua.laporan.balita');
                    }
                }
            } elseif ($role === 'kader') {
                if ($n->tipe === 'jadwal') {
                    $link = route('jadwal-posyandu.public');
                } elseif ($n->tipe === 'pemeriksaan') {
                    if (str_contains(strtolower($n->judul), 'ibu') || str_contains(strtolower($n->pesan), 'ibu')) {
                        $link = route('kader.pemeriksaan-awal-ibu-hamil.index');
                    } else {
                        $link = route('kader.pemeriksaan-awal-balita.index');
                    }
                }
            } elseif ($role === 'bidan') {
                if ($n->tipe === 'jadwal') {
                    $link = route('jadwal-posyandu.public');
                } elseif ($n->tipe === 'pemeriksaan') {
                    if (str_contains(strtolower($n->judul), 'ibu') || str_contains(strtolower($n->pesan), 'ibu')) {
                        $link = route('bidan.pemeriksaan-lanjutan-ibu-hamil.index');
                    } else {
                        $link = route('bidan.pemeriksaan-lanjutan-balita.index');
                    }
                }
            }

            $items[] = [
                'id'      => $n->id,
                'judul'   => $n->judul,
                'text'    => $n->pesan,
                'icon'    => $icon,
                'color'   => $color,
                'bg'      => $bg,
                'time'    => $n->created_at ? $n->created_at->diffForHumans() : null,
                'link'    => $link,
                'is_read' => (int)$n->is_read,
            ];
        }

        return response()->json([
            'count' => $unreadCount,
            'items' => $items,
        ]);
    }

    public function markAsRead($id)
    {
        $notif = \App\Models\Notifikasi::where('user_id', auth()->id())->findOrFail($id);
        $notif->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        \App\Models\Notifikasi::where('user_id', auth()->id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    public function search(Request $request)
    {
        $q    = trim($request->input('q', ''));
        $role = auth()->user()->role ?? '';

        $results = [];

        // ── Halaman (static, berdasarkan role) ──────────────────────────────
        $allPages = [];

        if ($role === 'ketua') {
            $allPages = [
                ['label' => 'Dashboard',                   'url' => route('ketua.dashboard'),           'icon' => 'fa-th-large'],
                ['label' => 'Data Ibu Hamil',              'url' => route('ibu-hamil.index'),           'icon' => 'fa-person-pregnant'],
                ['label' => 'Data Balita',                 'url' => route('balita.index'),              'icon' => 'fa-baby'],
                ['label' => 'Kelola Pengguna',             'url' => route('ketua.users.index'),         'icon' => 'fa-users-cog'],
                ['label' => 'Pemeriksaan Awal Ibu Hamil',  'url' => route('kader.pemeriksaan-awal-ibu-hamil.index'),    'icon' => 'fa-stethoscope'],
                ['label' => 'Pemeriksaan Awal Balita',     'url' => route('kader.pemeriksaan-awal-balita.index'),       'icon' => 'fa-child'],
                ['label' => 'Pemeriksaan Lanjutan Ibu Hamil', 'url' => route('bidan.pemeriksaan-lanjutan-ibu-hamil.index'), 'icon' => 'fa-notes-medical'],
                ['label' => 'Pemeriksaan Lanjutan Balita',    'url' => route('bidan.pemeriksaan-lanjutan-balita.index'),    'icon' => 'fa-syringe'],
                ['label' => 'Laporan Laporan',             'url' => route('ketua.laporan.index'),       'icon' => 'fa-chart-bar'],
                ['label' => 'Laporan Ibu Hamil',           'url' => route('ketua.laporan.ibu-hamil'),   'icon' => 'fa-file-medical'],
                ['label' => 'Laporan Balita',              'url' => route('ketua.laporan.balita'),      'icon' => 'fa-file-medical'],
                ['label' => 'Jadwal Posyandu',             'url' => route('ketua.jadwal-posyandu.index'),'icon' => 'fa-calendar-days'],
                ['label' => 'Kalender',                    'url' => route('kalender'),                  'icon' => 'fa-calendar-alt'],
            ];
        } elseif ($role === 'kader') {
            $allPages = [
                ['label' => 'Dashboard',                        'url' => route('kader.dashboard'),                            'icon' => 'fa-th-large'],
                ['label' => 'Data Ibu Hamil',                   'url' => route('ibu-hamil.index'),                            'icon' => 'fa-person-pregnant'],
                ['label' => 'Data Balita',                      'url' => route('balita.index'),                               'icon' => 'fa-baby'],
                ['label' => 'Pemeriksaan Awal Ibu Hamil',       'url' => route('kader.pemeriksaan-awal-ibu-hamil.index'),    'icon' => 'fa-stethoscope'],
                ['label' => 'Pemeriksaan Awal Balita',          'url' => route('kader.pemeriksaan-awal-balita.index'),       'icon' => 'fa-child'],
                ['label' => 'Kalender',                         'url' => route('kalender'),                                  'icon' => 'fa-calendar-alt'],
            ];
        } elseif ($role === 'bidan') {
            $allPages = [
                ['label' => 'Dashboard',                          'url' => route('bidan.dashboard'),                               'icon' => 'fa-th-large'],
                ['label' => 'Pemeriksaan Lanjutan Ibu Hamil',     'url' => route('bidan.pemeriksaan-lanjutan-ibu-hamil.index'),   'icon' => 'fa-notes-medical'],
                ['label' => 'Pemeriksaan Lanjutan Balita',        'url' => route('bidan.pemeriksaan-lanjutan-balita.index'),      'icon' => 'fa-syringe'],
                ['label' => 'Kalender',                           'url' => route('kalender'),                                     'icon' => 'fa-calendar-alt'],
            ];
        } elseif ($role === 'orang_tua') {
            $allPages = [
                ['label' => 'Dashboard',                   'url' => route('orang-tua.dashboard'),       'icon' => 'fa-th-large'],
                ['label' => 'Riwayat Ibu Hamil',           'url' => route('orang-tua.riwayat.ibu-hamil'),'icon' => 'fa-person-pregnant'],
                ['label' => 'Riwayat Balita',              'url' => route('orang-tua.riwayat.balita'),   'icon' => 'fa-baby'],
                ['label' => 'Jadwal Posyandu',             'url' => route('jadwal-posyandu.public'),     'icon' => 'fa-calendar-alt'],
                ['label' => 'Kalender',                    'url' => route('kalender'),                  'icon' => 'fa-calendar-alt'],
            ];
        }

        if ($q !== '') {
            $pageMatches = array_values(array_filter($allPages, function ($page) use ($q) {
                return stripos($page['label'], $q) !== false;
            }));
            $results['halaman'] = array_slice($pageMatches, 0, 5);
        } else {
            $results['halaman'] = [];
        }

        // ── Balita ──────────────────────────────────────────────────────────
        $results['balita'] = [];
        if ($q !== '' && in_array($role, ['ketua', 'kader'])) {
            $balitas = Balita::where('nama_balita', 'like', "%{$q}%")
                ->orWhere('nik', 'like', "%{$q}%")
                ->limit(5)
                ->get(['id', 'nama_balita', 'nik', 'jenis_kelamin']);

            foreach ($balitas as $b) {
                $results['balita'][] = [
                    'label' => $b->nama_balita,
                    'sub'   => 'NIK: ' . $b->nik,
                    'url'   => route('balita.show', $b->id),
                    'icon'  => 'fa-baby',
                ];
            }
        }

        // ── Ibu Hamil ───────────────────────────────────────────────────────
        $results['ibu_hamil'] = [];
        if ($q !== '' && in_array($role, ['ketua', 'kader'])) {
            $ibuHamils = IbuHamil::where('nama_ibu', 'like', "%{$q}%")
                ->orWhere('nik', 'like', "%{$q}%")
                ->limit(5)
                ->get(['id', 'nama_ibu', 'nik']);

            foreach ($ibuHamils as $ibu) {
                $results['ibu_hamil'][] = [
                    'label' => $ibu->nama_ibu,
                    'sub'   => 'NIK: ' . $ibu->nik,
                    'url'   => route('ibu-hamil.show', $ibu->id),
                    'icon'  => 'fa-person-pregnant',
                ];
            }
        }

        // ── User (ketua only) ────────────────────────────────────────────────
        $results['user'] = [];
        if ($q !== '' && $role === 'ketua') {
            $users = \App\Models\User::where('nama', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->limit(5)
                ->get(['id', 'nama', 'email', 'role']);

            foreach ($users as $u) {
                $results['user'][] = [
                    'label' => $u->nama,
                    'sub'   => ($u->role === 'ketua' ? 'Ketua Posyandu' : ucfirst($u->role)) . ' · ' . $u->email,
                    'url'   => route('ketua.users.show', $u->id),
                    'icon'  => 'fa-user',
                ];
            }
        }

        return response()->json($results);
    }
}