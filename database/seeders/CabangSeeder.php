<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cabang')->insert([
            [
                'nama_cabang' => 'Cabang A',
                'alamat' => 'Jalan-jalan',
                'jam_masuk' => '09:45:00',
                'jam_pulang' => '22:00:00',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_cabang' => 'Cabang B',
                'alamat' => 'Jalan-jalan santai',
                'jam_masuk' => '08:00:00',
                'jam_pulang' => '17:30:00',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_cabang' => 'Cabang C',
                'alamat' => 'Jalan-jalan',
                'jam_masuk' => '09:45:00',
                'jam_pulang' => '22:00:00',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_cabang' => 'Cabang D',
                'alamat' => 'Jalan-jalan',
                'jam_masuk' => '09:00:00',
                'jam_pulang' => '17:00:00',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
