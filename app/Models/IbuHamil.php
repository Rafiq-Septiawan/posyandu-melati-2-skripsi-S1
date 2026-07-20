<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamil extends Model
{
    protected $table = 'ibu_hamil';

    protected $fillable = [
        'user_id',
        'nama_ibu',
        'nik',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'gravida',
        'partus',
        'abortus',
        'hpht',
        'created_by',
        'updated_by', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function balita()
    {
        return $this->hasMany(Balita::class);
    }

    public function pemeriksaanAwal()
    {
        return $this->hasMany(PemeriksaanAwalIbuHamil::class);
    }

    public function pemeriksaanLanjutan()
    {
        return $this->hasMany(PemeriksaanLanjutanIbuHamil::class);
    }

    // tambah dua relasi ini
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}