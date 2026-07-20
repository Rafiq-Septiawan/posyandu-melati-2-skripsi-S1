<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanAwalBalita extends Model
{
    protected $table = 'pemeriksaan_awal_balita';

    protected $fillable = [
        'balita_id',
        'kader_id',
        'created_by',
        'updated_by',
        'tanggal_periksa',
        'usia_balita',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lingkar_lengan',
        'keluhan',
    ];

    public static function booted()
    {
        static::created(function ($model) {
            $balita = $model->balita;
            if ($balita) {
                if ($balita->ibuHamil && $balita->ibuHamil->user_id) {
                    Notifikasi::create([
                        'user_id' => $balita->ibuHamil->user_id,
                        'judul'   => 'Pemeriksaan Awal Balita Baru',
                        'pesan'   => "Pemeriksaan awal untuk balita {$balita->nama_balita} telah dicatat oleh kader pada tanggal {$model->tanggal_periksa}.",
                        'tipe'    => 'pemeriksaan',
                        'is_read' => 0,
                    ]);
                }

                $staff = User::whereIn('role', ['bidan', 'ketua'])->get();
                foreach ($staff as $s) {
                    Notifikasi::create([
                        'user_id' => $s->id,
                        'judul'   => 'Pemeriksaan Awal Balita Baru',
                        'pesan'   => "Pemeriksaan awal untuk balita {$balita->nama_balita} telah dicatat oleh kader pada tanggal {$model->tanggal_periksa}.",
                        'tipe'    => 'pemeriksaan',
                        'is_read' => 0,
                    ]);
                }
            }
        });
    }

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'balita_id');
    }

    public function kader()
    {
        return $this->belongsTo(User::class, 'kader_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function pemeriksaanLanjutan()
    {
        return $this->hasOne(PemeriksaanLanjutanBalita::class, 'pemeriksaan_awal_id');
    }
}