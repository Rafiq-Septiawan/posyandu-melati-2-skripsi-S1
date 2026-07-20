<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPosyandu extends Model
{
    protected $table = 'jadwal_posyandu';

    protected $fillable = [
        'judul',
        'tanggal',
        'jam',
        'lokasi',
        'keterangan',
        'status',
        'created_by',
    ];

    public static function booted()
    {
        static::created(function ($model) {
            $users = User::all();
            $formattedTime = \Carbon\Carbon::parse($model->jam)->format('H:i');
            foreach ($users as $user) {
                Notifikasi::create([
                    'user_id' => $user->id,
                    'judul'   => 'Jadwal Posyandu Baru',
                    'pesan'   => "Jadwal posyandu baru telah ditambahkan: {$model->judul} pada tanggal {$model->tanggal} pukul {$formattedTime} di {$model->lokasi}.",
                    'tipe'    => 'jadwal',
                    'is_read' => 0,
                ]);
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
