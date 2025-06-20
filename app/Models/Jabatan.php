<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $fillable = [
        'staff_id', 'jabatan','tanggal_mulai', 'tanggal_selesai'
    ];
    public function staff(){
        return $this-> belongsTo(Staff::class,'staff_id','id');
    }
}
