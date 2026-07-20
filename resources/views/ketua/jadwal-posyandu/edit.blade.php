@extends('layouts.app')

@section('title', 'Edit Jadwal Posyandu — Posyandu Melati 2')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Edit Jadwal Posyandu</h2>
        <p>Ubah detail informasi mengenai jadwal pelaksanaan posyandu.</p>
    </div>
    <div style="margin-left: auto;">
        <a href="{{ route('ketua.jadwal-posyandu.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-calendar-check" style="color: var(--teal-600);"></i>
        <div class="card-title">Formulir Edit Jadwal</div>
    </div>
    
    <form action="{{ route('ketua.jadwal-posyandu.update', $jadwal_posyandu->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-section">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="judul">Judul Kegiatan <span class="required">*</span></label>
                    <input type="text" id="judul" name="judul" class="form-control" placeholder="Contoh: Posyandu Balita & Ibu Hamil Rutin" value="{{ old('judul', $jadwal_posyandu->judul) }}" required>
                    @error('judul')
                        <div class="form-hint" style="color: var(--rose-500);">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="status">Status Kegiatan <span class="required">*</span></label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="aktif" {{ old('status', $jadwal_posyandu->status) === 'aktif' ? 'selected' : '' }}>Aktif (Diumumkan)</option>
                        <option value="selesai" {{ old('status', $jadwal_posyandu->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ old('status', $jadwal_posyandu->status) === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status')
                        <div class="form-hint" style="color: var(--rose-500);">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row-3" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" for="tanggal">Tanggal Pelaksanaan <span class="required">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ old('tanggal', $jadwal_posyandu->tanggal) }}" required>
                    @error('tanggal')
                        <div class="form-hint" style="color: var(--rose-500);">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="jam">Waktu Mulai <span class="required">*</span></label>
                    <input type="time" id="jam" name="jam" class="form-control" value="{{ old('jam', \Carbon\Carbon::parse($jadwal_posyandu->jam)->format('H:i')) }}" required>
                    @error('jam')
                        <div class="form-hint" style="color: var(--rose-500);">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="lokasi">Lokasi / Tempat <span class="required">*</span></label>
                    <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Contoh: Kantor RW 02" value="{{ old('lokasi', $jadwal_posyandu->lokasi) }}" required>
                    @error('lokasi')
                        <div class="form-hint" style="color: var(--rose-500);">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row-1">
                <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan / Pengumuman Tambahan</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" rows="4" placeholder="Contoh: Harap membawa buku KIA dan fotokopi KK bagi peserta baru.">{{ old('keterangan', $jadwal_posyandu->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="form-hint" style="color: var(--rose-500);">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('ketua.jadwal-posyandu.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Jadwal</button>
        </div>
    </form>
</div>
@endsection
