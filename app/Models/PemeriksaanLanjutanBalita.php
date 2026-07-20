<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanLanjutanBalita extends Model
{
    protected $table = 'pemeriksaan_lanjutan_balita';

    protected $fillable = [
        'balita_id',
        'pemeriksaan_awal_id',
        'bidan_id',
        'created_by',
        'updated_by',
        'tanggal_periksa',
        'status_gizi',
        'imunisasi',
        'vitamin_a',
        'catatan_bidan',
        'tindak_lanjut',
    ];

    public static function booted()
    {
        static::created(function ($model) {
            $balita = $model->balita;
            if ($balita) {
                if ($balita->ibuHamil && $balita->ibuHamil->user_id) {
                    Notifikasi::create([
                        'user_id' => $balita->ibuHamil->user_id,
                        'judul'   => 'Pemeriksaan Lanjutan Balita Baru',
                        'pesan'   => "Pemeriksaan lanjutan (bidan) untuk balita {$balita->nama_balita} telah dicatat oleh bidan pada tanggal {$model->tanggal_periksa}.",
                        'tipe'    => 'pemeriksaan',
                        'is_read' => 0,
                    ]);
                }

                $staff = User::whereIn('role', ['kader', 'ketua'])->get();
                foreach ($staff as $s) {
                    Notifikasi::create([
                        'user_id' => $s->id,
                        'judul'   => 'Pemeriksaan Lanjutan Balita Baru',
                        'pesan'   => "Pemeriksaan lanjutan (bidan) untuk balita {$balita->nama_balita} telah dicatat oleh bidan pada tanggal {$model->tanggal_periksa}.",
                        'tipe'    => 'pemeriksaan',
                        'is_read' => 0,
                    ]);
                }
            }
        });
    }

    public function balita()
    {
        return $this->belongsTo(Balita::class);
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
        return $this->belongsTo(PemeriksaanAwalBalita::class, 'pemeriksaan_awal_id');
    }
}