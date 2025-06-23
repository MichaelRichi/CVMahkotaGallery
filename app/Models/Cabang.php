<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang';
    protected $fillable = [
        'nama_cabang',
        'alamat',
        'jam_masuk',
        'jam_pulang',
        'is_active'
    ];
    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'staff_cabang');
    }
}
