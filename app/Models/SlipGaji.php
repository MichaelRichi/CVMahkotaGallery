<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    protected $table = 'slip_gaji';
    protected $fillable = [
        'staff_id',
        'cabang_id',
        'periode',
        'tanggal_penggajian',
        'gaji_pokok',
        'gaji_tunjangan',
        'potongan_izin',
        'potongan_kronologi',
        'potongan_hutang',
        'gaji_bersih',

    ];
}
