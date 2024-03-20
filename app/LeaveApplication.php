<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    protected $fillable = [
        'user_id', 'jenis_izin_id', 'tanggal_mulai', 'tanggal_selesai', 'alasan', 'status', 'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class);
    }
}
