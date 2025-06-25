<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPinjaman extends Model
{
    protected $table = 'pengajuan_pinjaman';

    protected $fillable = [
        'staff_id', 'jumlah_pinjaman', 'periode_pelunasan', 'start_pelunasan',
        'alasan', 'validasi_admin', 'admin_id'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function admin()
    {
        return $this->belongsTo(Staff::class, 'admin_id');
    }
}
