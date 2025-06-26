<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Hutang;
use App\Models\DetailHutang;
use App\Models\SlipGaji;
use App\Models\Staff;

use Illuminate\Support\Facades\DB;

class SlipGajiController extends Controller
{
    /**
     * Menampilkan halaman penggajian dengan filter berdasarkan cabang
     * Mengambil data staff dan menghitung gaji bersih berdasarkan potongan hutang dari detail hutang
     */
    public function preview(Request $request)
    {
        $cabangId = $request->input('cabang_id');
        $staffQuery = Staff::query();

        // Filter staff berdasarkan cabang jika ada
        if ($cabangId) {
            $staffQuery->where('cabang_id', $cabangId);
        }

        $staff = $staffQuery->with('cabang')->get()->map(function ($staff) {
            // Ambil hutang kronologi dan peminjaman yang sedang berjalan
            $hutangKronologi = Hutang::where('staff_id', $staff->id)
                ->where('jenis', 'kronologi')
                ->first();
            $hutangPeminjaman = Hutang::where('staff_id', $staff->id)
                ->where('jenis', 'pinjam')
                ->first();

            $gajiBersih = $staff->gaji_pokok + $staff->gaji_tunjangan;
            $potonganKronologi = 0;
            $potonganPeminjaman = 0;

            // Hitung potongan dari detail hutang untuk bulan ini
            $currentMonth = Carbon::now()->month;
            if ($hutangKronologi) {
                $detailKronologi = DetailHutang::where('hutang_id', $hutangKronologi->id)
                    ->whereMonth('tanggal_pelunasan', $currentMonth)
                    ->where('status', '!=', '1')
                    ->first();
                if ($detailKronologi) {
                    $potonganKronologi = $detailKronologi->jumlah_hutang;
                }
            }

            if ($hutangPeminjaman) {
                $detailPeminjaman = DetailHutang::where('hutang_id', $hutangPeminjaman->id)
                    ->whereMonth('tanggal_pelunasan', $currentMonth)
                    ->where('status', '!=', '1')
                    ->first();
                if ($detailPeminjaman) {
                    $potonganPeminjaman = $detailPeminjaman->jumlah_hutang;
                }
            }

            // Kurangi gaji bersih berdasarkan potongan
            $gajiBersih -= ($potonganKronologi + $potonganPeminjaman);

            // Perbarui sisa hutang jika ada potongan
            // if ($hutangKronologi && $potonganKronologi > 0) {
            //     $hutangKronologi->sisa_hutang -= $potonganKronologi;
            //     if ($hutangKronologi->sisa_hutang <= 0) {
            //         $hutangKronologi->status = 'LUNAS';
            //     }
            //     $hutangKronologi->save();
            // }

            // if ($hutangPeminjaman && $potonganPeminjaman > 0) {
            //     $hutangPeminjaman->sisa_hutang -= $potonganPeminjaman;
            //     if ($hutangPeminjaman->sisa_hutang <= 0) {
            //         $hutangPeminjaman->status = 'LUNAS';
            //     }
            //     $hutangPeminjaman->save();
            // }

            $staff->gaji_bersih = $gajiBersih > 0 ? $gajiBersih : 0;
            $staff->potongan_kronologi = $potonganKronologi;
            $staff->potongan_peminjaman = $potonganPeminjaman;
            return $staff;
        });

        $cabang = \App\Models\Cabang::all();
        return view('slip.index', compact('staff', 'cabang'));
    }

    /**
     * Memproses penggajian untuk semua staff
     * Mengisi tabel slip_gaji dan memperbarui status detail hutang
     */
    public function proses()
    {
        $staff = Staff::with('cabang')->get();
        $currentMonth = Carbon::now()->month;
        $currentDate = Carbon::now();

        foreach ($staff as $s) {
            $hutangKronologi = Hutang::where('staff_id', $s->id)
                ->where('jenis', 'kronologi')
                ->first();

            $hutangPeminjaman = Hutang::where('staff_id', $s->id)
                ->where('jenis', 'pinjam')
                ->first();

            $gajiBersih = $s->gaji_pokok + $s->gaji_tunjangan;
            $potonganKronologi = 0;
            $potonganPeminjaman = 0;

            // Ambil potongan dari detail hutang untuk bulan ini
            if ($hutangKronologi) {
                $detailKronologi = DetailHutang::where('hutang_id', $hutangKronologi->id)
                    ->whereMonth('tanggal_pelunasan', $currentMonth)
                    ->where('status', '!=', '1')
                    ->first();

                if ($detailKronologi) {
                    $potonganKronologi = $detailKronologi->jumlah_hutang;
                    $detailKronologi->status = '1';
                    $detailKronologi->save();

                    $hutangKronologi->sisa_hutang -= $potonganKronologi;
                    if ($hutangKronologi->sisa_hutang <= 0) {
                        $hutangKronologi->status = 'LUNAS';
                    }
                    $hutangKronologi->save();
                }
            }

            if ($hutangPeminjaman) {
                $detailPeminjaman = DetailHutang::where('hutang_id', $hutangPeminjaman->id)
                    ->whereMonth('tanggal_pelunasan', $currentMonth)
                    ->where('status', '!=', '1')
                    ->first();
                if ($detailPeminjaman) {
                    $potonganPeminjaman = $detailPeminjaman->jumlah_hutang;
                    $detailPeminjaman->status = '1';
                    $detailPeminjaman->save();

                    $hutangPeminjaman->sisa_hutang -= $potonganPeminjaman;
                    if ($hutangPeminjaman->sisa_hutang <= 0) {
                        $hutangPeminjaman->status = 'LUNAS';
                    }
                    $hutangPeminjaman->save();
                }
            }

            $gajiBersih -= ($potonganKronologi + $potonganPeminjaman);

            SlipGaji::create([
                'staff_id' => $s->id,
                'cabang_id' => $s->cabang_id,
                'periode' => $currentMonth,
                'tanggal_penggajian' => $currentDate,
                'gaji_pokok' => $s->gaji_pokok,
                'gaji_tunjangan' => $s->gaji_tunjangan,
                'potongan_izin' => 0,
                'potongan_kronologi' => $potonganKronologi,
                'potongan_hutang' => $potonganPeminjaman,
                'gaji_bersih' => $gajiBersih > 0 ? $gajiBersih : 0,
                'status' => 'PROCESSED'
            ]);
        }

        return redirect()->route('slip.index')->with('success', 'Penggajian berhasil diproses!');
    }
}
