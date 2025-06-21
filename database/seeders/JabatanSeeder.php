<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jabatan')->insert([
            
            [
                'nama_jabatan'=>'Admin'
            ],
            [
                'nama_jabatan'=>'Kepala Cabang'
            ],
            [
                'nama_jabatan'=>'Karyawan'
            ],
        ]);
    }
}