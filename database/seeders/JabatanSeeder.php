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
                'staff_id'=>1,
                'jabatan'=>'Kepala Cabang',
                'tanggal_mulai'=>'2021-01-10',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>2,
                'jabatan'=>'Admin',
                'tanggal_mulai'=>'2020-05-01',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>3,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2019-11-12',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>4,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2022-01-01',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>5,
                'jabatan'=>'Kepala Cabang',
                'tanggal_mulai'=>'2025-01-01',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>6,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2021-03-10',
                'tanggal_selesai'=>'2024-03-10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>7,
                'jabatan'=>'Kepala Cabang',
                'tanggal_mulai'=>'2020-06-15',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>8,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2025-03-20',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>9,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2022-10-01',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>10,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2024-07-01',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>11,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2023-01-01',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>12,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2024-05-05',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>13,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2020-09-15',
                'tanggal_selesai'=>'2022-09-15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>14,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2025-02-02',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>15,
                'jabatan'=>'Kepala Cabang',
                'tanggal_mulai'=>'2018-03-03',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>16,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2024-08-08',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>17,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2024-07-01',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>18,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2025-04-04',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>19,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2020-02-02',
                'tanggal_selesai'=>'2023-02-02',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_id'=>20,
                'jabatan'=>'Karyawan',
                'tanggal_mulai'=>'2021-09-09',
                'tanggal_selesai'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
