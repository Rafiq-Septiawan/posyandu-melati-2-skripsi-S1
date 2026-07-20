<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanAwalIbuHamil extends Model
{
    protected $table = 'pemeriksaan_awal_ibu_hamil';

    protected $fillable = [
        'ibu_hamil_id',
        'kader_id',
        'created_by',
        'updated_by',
        'tanggal_periksa',
        'usia_kehamilan',
        'berat_badan',
        'tekanan_darah',
        'keluhan',
    ];

    public static function booted()
    {
        static::created(function ($model) {
            $ibuHamil = $model->ibuHamil;
            if ($ibuHamil) {
                if ($ibuHamil->user_id) {
                    Notifikasi::create([
                        'user_id' => $ibuHamil->user_id,
                        'judul'   => 'Pemeriksaan Awal Ibu Hamil Baru',
                        'pesan'   => "Pemeriksaan awal ibu hamil atas nama {$ibuHamil->nama_ibu} telah dicatat oleh kader pada tanggal {$model->tanggal_periksa}.",
                        'tipe'    => 'pemeriksaan',
                        'is_read' => 0,
                    ]);
                }

                $staff = User::whereIn('role', ['bidan', 'ketua'])->get();
                foreach ($staff as $s) {
                    Notifikasi::create([
                        'user_id' => $s->id,
                        'judul'   => 'Pemeriksaan Awal Ibu Hamil Baru',
                        'pesan'   => "Pemeriksaan awal ibu hamil atas nama {$ibuHamil->nama_ibu} telah dicatat oleh kader pada tanggal {$model->tanggal_periksa}.",
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
        return $this->hasOne(PemeriksaanLanjutanIbuHamil::class, 'pemeriksaan_awal_id');
    }
}