<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StaffJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('staff_jabatan')->insert([
            [
                'staff_id'=>1,
                'jabatan_id'=>2,
                'tanggal_mulai'=>'2021-01-10',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>2,
                'jabatan_id'=>1,
                'tanggal_mulai'=>'2020-05-01',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>3,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2019-11-12',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>4,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2022-01-01',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>5,
                'jabatan_id'=>2,
                'tanggal_mulai'=>'2025-01-01',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>6,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2021-03-10',
                'tanggal_selesai'=>'2024-03-10',
                'is_active' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>7,
                'jabatan_id'=>2,
                'tanggal_mulai'=>'2020-06-15',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>8,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2025-03-20',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>9,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2022-10-01',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>10,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2024-07-01',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>11,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2023-01-01',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>12,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2024-05-05',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>13,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2020-09-15',
                'tanggal_selesai'=>'2022-09-15',
                'is_active' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>14,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2025-02-02',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>15,
                'jabatan_id'=>2,
                'tanggal_mulai'=>'2018-03-03',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>16,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2024-08-08',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>17,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2024-07-01',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>18,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2025-04-04',
                'tanggal_selesai'=>null,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>19,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2020-02-02',
                'tanggal_selesai'=>'2023-02-02',
                'is_active' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>20,
                'jabatan_id'=>3,
                'tanggal_mulai'=>'2021-09-09',
                'tanggal_selesai'=>null,
                'is_active' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
