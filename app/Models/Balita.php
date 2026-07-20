<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $table = 'balita';

    protected $fillable = [
        'ibu_hamil_id',
        'nama_balita',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'created_by', 
        'updated_by', 
    ];

    public function ibuHamil()
    {
        return $this->belongsTo(IbuHamil::class, 'ibu_hamil_id');
    }

    public function pemeriksaanAwal()
    {
        return $this->hasMany(PemeriksaanAwalBalita::class);
    }

    public function pemeriksaanLanjutan()
    {
        return $this->hasMany(PemeriksaanLanjutanBalita::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}