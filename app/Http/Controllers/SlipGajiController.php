<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Hutang;
use App\Models\DetailHutang;
use App\Models\SlipGaji;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class SlipGajiController extends Controller
{
    /**
     * Menampilkan halaman penggajian dengan filter berdasarkan cabang
     * Mengambil data staff dan menghitung gaji bersih berdasarkan potongan hutang dari detail hutang
     */
    public function view(Request $request)
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

    public function proses(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Validasi input dan konversi ke integer
        $month = (int)$month;
        $year = (int)$year;
        $periodeDate = Carbon::create($year, $month, 1)->toDateString();

        if (!$month || !$year || $month < 1 || $month > 12 || $year < 2000 || $year > 2100) {
            return redirect()->back()->with('error', 'Silakan pilih bulan dan tahun yang valid sebelum memproses penggajian.');
        }

        // Cek apakah penggajian untuk bulan dan tahun ini sudah dilakukan
        $existingPayroll = SlipGaji::where('periode', $periodeDate)->exists();

        if ($existingPayroll) {
            $monthName = Carbon::create($year, $month, 1)->format('F');
            return redirect()->back()->with('error', 'Gaji bulan ' . $monthName . ' ' . $year . ' sudah dilakukan, anda bisa melihat record gaji di riwayat gaji.');
        }

        $staff = Staff::with('cabang')->get();
        $currentDate = Carbon::now(); // Gunakan tanggal saat ini untuk tanggal_pengajian

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

            if ($hutangKronologi) {
                $detailKronologi = DetailHutang::where('hutang_id', $hutangKronologi->id)
                    ->whereMonth('tanggal_pelunasan', $month)
                    ->whereYear('tanggal_pelunasan', $year)
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
                    ->whereMonth('tanggal_pelunasan', $month)
                    ->whereYear('tanggal_pelunasan', $year)
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
                'cabang_id' => $s->cabang[0]->id,
                'periode' => $periodeDate,
                'tanggal_penggajian' => $currentDate,
                'gaji_pokok' => $s->gaji_pokok,
                'gaji_tunjangan' => $s->gaji_tunjangan,
                'potongan_izin' => 0,
                'potongan_kronologi' => $potonganKronologi,
                'potongan_hutang' => $potonganPeminjaman,
                'gaji_bersih' => $gajiBersih > 0 ? $gajiBersih : 0,
            ]);
        }

        return redirect()->route('slip.view')->with('success', 'Penggajian berhasil diproses untuk bulan ' . Carbon::create($year, $month, 1)->format('F') . ' ' . $year . '!');
    }


    public function riwayat(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $query = SlipGaji::with(['staff', 'cabang']);

        if ($month) {
            $query->whereMonth('periode', $month);
        }

        if ($year) {
            $query->whereYear('periode', $year);
        }

        $payrolls = $query->get();

        return view('slip.riwayat', compact('payrolls'));
    }

    public function riwayatGajiKaryawan(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $staffId = Auth::user()->id; // Asumsikan staff_id tersedia dari user yang login

        // Validasi staff_id
        if (!$staffId) {
            Log::error('Staff ID tidak ditemukan untuk user: ' . Auth::user()->id);
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan hubungi admin.');
        }

        $query = SlipGaji::with(['staff'])
            ->where('staff_id', $staffId);

        // Tambahkan filter jika ada
        if ($month) {
            $query->whereMonth('periode', $month);
        }

        if ($year) {
            $query->whereYear('periode', $year);
        }

        $payrolls = $query->get();

        // Debugging
        Log::info('Query riwayat gaji untuk staff_id ' . $staffId . ': ', $payrolls->toArray());

        if ($payrolls->isEmpty()) {
            Log::warning('Tidak ada data riwayat gaji untuk staff_id ' . $staffId . ' pada ' . now());
        }

        return view('slip.riwayat_gaji_karyawan', compact('payrolls'));
    }
}
