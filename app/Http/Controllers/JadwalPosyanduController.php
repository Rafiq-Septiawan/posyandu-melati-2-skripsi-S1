<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JadwalPosyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPosyanduController extends Controller
{
    /**
     * Tampilan untuk Ketua: daftar semua jadwal
     */
    public function index(Request $request)
    {
        $jadwals = JadwalPosyandu::latest('tanggal')->paginate(10);
        return view('ketua.jadwal-posyandu.index', compact('jadwals'));
    }

    public function create()
    {
        return view('ketua.jadwal-posyandu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'jam'        => 'required|string',
            'lokasi'     => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
            'status'     => 'required|in:aktif,selesai,dibatalkan',
        ], [
            'judul.required'   => 'Judul jadwal wajib diisi.',
            'tanggal.required' => 'Tanggal jadwal wajib diisi.',
            'jam.required'     => 'Jam jadwal wajib diisi.',
            'lokasi.required'  => 'Lokasi jadwal wajib diisi.',
            'status.required'  => 'Status jadwal wajib dipilih.',
        ]);

        JadwalPosyandu::create([
            'judul'      => $request->judul,
            'tanggal'    => $request->tanggal,
            'jam'        => $request->jam,
            'lokasi'     => $request->lokasi,
            'keterangan' => $request->keterangan,
            'status'     => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ketua.jadwal-posyandu.index')
            ->with('success', 'Jadwal posyandu berhasil ditambahkan.');
    }

    public function show(JadwalPosyandu $jadwal_posyandu)
    {
        return view('ketua.jadwal-posyandu.show', compact('jadwal_posyandu'));
    }

    public function edit(JadwalPosyandu $jadwal_posyandu)
    {
        return view('ketua.jadwal-posyandu.edit', compact('jadwal_posyandu'));
    }

    public function update(Request $request, JadwalPosyandu $jadwal_posyandu)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'jam'        => 'required|string',
            'lokasi'     => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
            'status'     => 'required|in:aktif,selesai,dibatalkan',
        ], [
            'judul.required'   => 'Judul jadwal wajib diisi.',
            'tanggal.required' => 'Tanggal jadwal wajib diisi.',
            'jam.required'     => 'Jam jadwal wajib diisi.',
            'lokasi.required'  => 'Lokasi jadwal wajib diisi.',
            'status.required'  => 'Status jadwal wajib dipilih.',
        ]);

        $jadwal_posyandu->update([
            'judul'      => $request->judul,
            'tanggal'    => $request->tanggal,
            'jam'        => $request->jam,
            'lokasi'     => $request->lokasi,
            'keterangan' => $request->keterangan,
            'status'     => $request->status,
        ]);

        return redirect()->route('ketua.jadwal-posyandu.index')
            ->with('success', 'Jadwal posyandu berhasil diperbarui.');
    }

    public function destroy(JadwalPosyandu $jadwal_posyandu)
    {
        $jadwal_posyandu->delete();

        return redirect()->route('ketua.jadwal-posyandu.index')
            ->with('success', 'Jadwal posyandu berhasil dihapus.');
    }

    /**
     * Tampilan publik (untuk orang tua) — read-only
     */
    public function publicIndex()
    {
        $jadwals = JadwalPosyandu::where('status', 'aktif')
            ->latest('tanggal')
            ->paginate(10);
        return view('orang-tua.jadwal-posyandu', compact('jadwals'));
    }
}
