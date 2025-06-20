<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $fillable = [
        'NIK',
        'nama',
        'JK',
        'TTL',
        'notel',
        'alamat',
        'tgl_masuk',
        'tgl_keluar',
        'gaji_pokok',
        'gaji_tunjangan',
        'users_id',
        'is_active',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    // 1 staff bisa kerja di banyak cabang | 1 cabang bisa memiliki banyak staff 
    public function cabang()
    {
        return $this->belongsToMany(Kelas::class, 'staff_cabang', 'staff_id', 'cabang_id')->withTimestamps();
    }
}
