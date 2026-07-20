<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanLanjutanIbuHamil extends Model
{
    protected $table = 'pemeriksaan_lanjutan_ibu_hamil';

    protected $fillable = [
        'ibu_hamil_id',
        'bidan_id',
        'created_by',
        'updated_by',
        'pemeriksaan_awal_id',
        'tanggal_periksa',
        'lila',
        'tfu',
        'djj',
        'catatan_bidan',
        'tindak_lanjut',
    ];

    public static function booted()
    {
        static::created(function ($model) {
            $ibuHamil = $model->ibuHamil;
            if ($ibuHamil) {
                if ($ibuHamil->user_id) {
                    Notifikasi::create([
                        'user_id' => $ibuHamil->user_id,
                        'judul'   => 'Pemeriksaan Lanjutan Ibu Hamil Baru',
                        'pesan'   => "Pemeriksaan lanjutan (bidan) ibu hamil atas nama {$ibuHamil->nama_ibu} telah dicatat oleh bidan pada tanggal {$model->tanggal_periksa}.",
                        'tipe'    => 'pemeriksaan',
                        'is_read' => 0,
                    ]);
                }

                $staff = User::whereIn('role', ['kader', 'ketua'])->get();
                foreach ($staff as $s) {
                    Notifikasi::create([
                        'user_id' => $s->id,
                        'judul'   => 'Pemeriksaan Lanjutan Ibu Hamil Baru',
                        'pesan'   => "Pemeriksaan lanjutan (bidan) ibu hamil atas nama {$ibuHamil->nama_ibu} telah dicatat oleh bidan pada tanggal {$model->tanggal_periksa}.",
                        'tipe'    => 'pemeriksaan',
                        'is_read' => 0,
                    ]);
                }
            }
        });
    }

    public function ibuHamil()
    {
        return $this->belongsTo(IbuHamil::class, 'ibu_hamil_id');
    }

    public function bidan()
    {
        return $this->belongsTo(User::class, 'bidan_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function pemeriksaanAwal()
    {
        return $this->belongsTo(PemeriksaanAwalIbuHamil::class, 'pemeriksaan_awal_id');
    }
}