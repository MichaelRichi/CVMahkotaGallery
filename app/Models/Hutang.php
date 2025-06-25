<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    protected $table = 'hutang';
    protected $fillable = [
        'staff_id', 'jumlah_hutang', 'periode_pelunasan', 'start_pelunasan',
        'keterangan', 'status', 'sisa_hutang', 'admin_id'
    ];

    public function staff() {
        return $this->belongsTo(Staff::class);
    }
    public function admin() {
        return $this->belongsTo(Staff::class, 'admin_id');
    }
}
