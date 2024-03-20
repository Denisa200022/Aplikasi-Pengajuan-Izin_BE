<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisIzin extends Model
{
    protected $fillable = [
        'nama', 'deskripsi',
    ];

    public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class);
    }
}
