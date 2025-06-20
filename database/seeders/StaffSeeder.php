<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('staff')->insert([
            [
                'NIK' => '3201010101010001',
                'nama' => 'Andi Saputra',
                'JK' => 'L',
                'TTL' => '1995-06-15',
                'notel' => '081234567891',
                'alamat' => 'Jl. Merdeka No.1, Bandung',
                'tgl_masuk' => '2021-01-10',
                'tgl_keluar' => null,
                'gaji_pokok' => 5500000,
                'gaji_tunjangan' => 1000000,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'NIK' => '3201010101010002',
                'nama' => 'Rina Kartika',
                'JK' => 'P',
                'TTL' => '1992-08-22',
                'notel' => '082112233445',
                'alamat' => 'Jl. Cempaka No.4, Jakarta',
                'tgl_masuk' => '2020-05-01',
                'tgl_keluar' => null,
                'gaji_pokok' => 6200000,
                'gaji_tunjangan' => 1500000,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'NIK' => '3201010101010003',
                'nama' => 'Dedi Supriadi',
                'JK' => 'L',
                'TTL' => '1988-03-30',
                'notel' => '081398765432',
                'alamat' => 'Jl. Raya Bogor No.20, Depok',
                'tgl_masuk' => '2019-11-12',
                'tgl_keluar' => null,
                'gaji_pokok' => 5000000,
                'gaji_tunjangan' => 1200000,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'NIK' => '3201010101010004',
                'nama' => 'Lisa Amalia',
                'JK' => 'P',
                'TTL' => '1990-12-05',
                'notel' => '081234567899',
                'alamat' => 'Jl. Kenanga No.2, Bekasi',
                'tgl_masuk' => '2022-01-01',
                'tgl_keluar' => null,
                'gaji_pokok' => 4800000,
                'gaji_tunjangan' => 950000,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'NIK' => '3201010101010005',
                'nama' => 'Budi Prasetyo',
                'JK' => 'L',
                'TTL' => '1985-05-17',
                'notel' => '081277665544',
                'alamat' => 'Jl. Melati No.10, Tangerang',
                'tgl_masuk' => '2025-01-01',
                'tgl_keluar' => null,
                'gaji_pokok' => 5300000,
                'gaji_tunjangan' => 1300000,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'NIK' => '3201010101010006',
                'nama' => 'Siti Rohmah',
                'JK' => 'P',
                'TTL' => '1993-11-11',
                'notel' => '082177889900',
                'alamat' => 'Jl. Diponegoro No.5, Semarang',
                'tgl_masuk' => '2021-03-10',
                'tgl_keluar' => '2024-03-10',
                'gaji_pokok' => 5100000,
                'gaji_tunjangan' => 800000,
                'is_active' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'NIK' => '3201010101010007',
                'nama' => 'Ahmad Fauzi',
                'JK' => 'L',
                'TTL' => '1994-09-09',
                'notel' => '081388899911',
                'alamat' => 'Jl. Kalimantan No.3, Surabaya',
                'tgl_masuk' => '2020-06-15',
                'tgl_keluar' => null,
                'gaji_pokok' => 6000000,
                'gaji_tunjangan' => 1100000,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'NIK' => '3201010101010008',
                'nama' => 'Desi Marlina',
                'JK' => 'P',
                'TTL' => '1991-07-20',
                'notel' => '082166778899',
                'alamat' => 'Jl. Gajah Mada No.9, Yogyakarta',
                'tgl_masuk' => '2025-03-20',
                'tgl_keluar' => null,
                'gaji_pokok' => 4700000,
                'gaji_tunjangan' => 900000,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'NIK' => '3201010101010009',
                'nama' => 'Ilham Maulana',
                'JK' => 'L',
                'TTL' => '1996-01-01',
                'notel' => '081233344455',
                'alamat' => 'Jl. Majapahit No.6, Malang',
                'tgl_masuk' => '2022-10-01',
                'tgl_keluar' => null,
                'gaji_pokok' => 4900000,
                'gaji_tunjangan' => 1050000,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'NIK' => '3201010101010010',
                'nama' => 'Tania Rizky',
                'JK' => 'P',
                'TTL' => '1989-02-25',
                'notel' => '081299887766',
                'alamat' => 'Jl. Imam Bonjol No.8, Medan',
                'tgl_masuk' => '2024-07-01',
                'tgl_keluar' => null,
                'gaji_pokok' => 5200000,
                'gaji_tunjangan' => 1100000,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            // lanjutkan sisa data ke-11 s/d 20 dengan pola yang sama...
        ]);
    }
}
