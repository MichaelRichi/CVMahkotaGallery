<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Hutang;
use App\Models\DetailHutang;
use App\Models\SlipGaji;
use App\Models\Absen;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


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
            $staffQuery->whereHas('cabang', function ($query) use ($cabangId) {
                $query->where('cabang.id', $cabangId);
            });
        }

        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $staff = $staffQuery->with('cabang')->get()->map(function ($staff) use ($month, $year) {
            // Ambil hutang kronologi dan peminjaman
            $hutangKronologi = Hutang::where('staff_id', $staff->id)
                ->where('jenis', 'kronologi')
                ->first();
            $hutangPeminjaman = Hutang::where('staff_id', $staff->id)
                ->where('jenis', 'pinjam')
                ->first();

            $gajiBersih = $staff->gaji_pokok + $staff->gaji_tunjangan;
            $potonganKronologi = 0;
            $potonganPeminjaman = 0;
            $potonganAbsenAlpha = 0;
            $potonganAbsenIzin = 0;
            $potonganTerlambat = 0;

            // Hitung potongan berdasarkan absen
            $daysInMonth = Carbon::create($year, $month)->daysInMonth;
            $dailyRate = $staff->gaji_pokok / $daysInMonth;

            $absenRecords = Absen::where('staff_id', $staff->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->get();

            $alphaDays = $absenRecords->where('status', 'A')->count();
            $izinDays = $absenRecords->where('status', 'I')->count();
            $terlambatDays = $absenRecords->where('status', 'T')->count();

            // Potongan Alpha
            if ($alphaDays > 0) {
                $potonganAbsenAlpha = $alphaDays * $dailyRate;
            }

            // Potongan Izin (hanya jika total Alpha + Izin > 3)
            $totalAbsentDays = $alphaDays + $izinDays;
            if ($totalAbsentDays > 3) {
                $extraIzinDays = max(0, $izinDays - ($totalAbsentDays - 3));
                $potonganAbsenIzin = $extraIzinDays * $dailyRate;
            }

            // Potongan Terlambat (Rp10.000 per hari)
            if ($terlambatDays > 0) {
                $potonganTerlambat = $terlambatDays * 10000;
            }

            // Hitung potongan dari detail hutang
            if ($hutangKronologi) {
                $detailKronologi = DetailHutang::where('hutang_id', $hutangKronologi->id)
                    ->whereMonth('tanggal_pelunasan', $month)
                    ->whereYear('tanggal_pelunasan', $year)
                    ->where('status', '!=', '1')
                    ->first();
                if ($detailKronologi) {
                    $potonganKronologi = $detailKronologi->jumlah_hutang;
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
                }
            }

            // Kurangi gaji bersih berdasarkan semua potongan
            $gajiBersih -= ($potonganKronologi + $potonganPeminjaman + $potonganAbsenAlpha + $potonganAbsenIzin + $potonganTerlambat);

            $staff->gaji_bersih = $gajiBersih > 0 ? $gajiBersih : 0;
            $staff->potongan_kronologi = $potonganKronologi;
            $staff->potongan_peminjaman = $potonganPeminjaman;
            $staff->potongan_absen_alpha = $potonganAbsenAlpha;
            $staff->potongan_absen_izin = $potonganAbsenIzin;
            $staff->potongan_terlambat = $potonganTerlambat;

            return $staff;
        });

        $cabang = Cabang::all();
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
            $potonganAbsenAlpha = 0;
            $potonganAbsenIzin = 0;
            $potonganTerlambat = 0;

            // Hitung potongan berdasarkan absen
            $daysInMonth = Carbon::create($year, $month)->daysInMonth; // Jumlah hari dalam bulan
            $dailyRate = $s->gaji_pokok / $daysInMonth; // Gaji per hari

            $absenRecords = Absen::where('staff_id', $s->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->get();

            $alphaDays = $absenRecords->where('status', 'A')->count();
            $terlambatDays = $absenRecords->where('status', 'T')->count();

            $izinDays     = $absenRecords->where('status', 'I')->count(); // Izin
            $offDays      = $absenRecords->where('status', 'O')->count(); // Off
            $sakitDays    = $absenRecords->where('status', 'S')->count(); // Sakit

            $totalIzinDays = $izinDays + $offDays + $sakitDays;

            // Potongan Alpha (langsung dipotong per hari)
            if ($alphaDays > 0) {
                $potonganAbsenAlpha = $alphaDays * $dailyRate;
            }

            // Potongan Izin (hanya jika total Alpha + Izin > 3)
            $totalAbsentDays = $alphaDays + $totalIzinDays;
            if ($totalAbsentDays > 3) {
                $extraIzinDays = max(0, $totalIzinDays - ($totalAbsentDays - 3)); // Hanya potong izin tambahan
                $potonganAbsenIzin = $extraIzinDays * $dailyRate;
            }

            // Potongan Terlambat (Rp10.000 per hari)
            if ($terlambatDays > 0) {
                $potonganTerlambat = $terlambatDays * 10000;
            }

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

            $gajiBersih -= ($potonganKronologi + $potonganPeminjaman + $potonganAbsenAlpha + $potonganAbsenIzin + $potonganTerlambat);

            SlipGaji::create([
                'staff_id' => $s->id,
                'cabang_id' => $s->cabang[0]->id ?? null,
                'periode' => $periodeDate,
                'tanggal_penggajian' => $currentDate,
                'gaji_pokok' => $s->gaji_pokok,
                'gaji_tunjangan' => $s->gaji_tunjangan,
                'potongan_izin' => $potonganAbsenIzin, // Gunakan potongan_izin untuk izin
                'potongan_kronologi' => $potonganKronologi,
                'potongan_hutang' => $potonganPeminjaman,
                'potongan_alpha' => $potonganAbsenAlpha, // Pisahkan potongan Alpha
                'potongan_terlambat' => $potonganTerlambat, // Tambahkan potongan terlambat
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

        return view('slip.riwayat_gaji_all', compact('payrolls'));
    }

    public function riwayatGajiKaryawan(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $user = Auth::user();
        $staff = \App\Models\Staff::where('users_id', $user->id)->first();
        $staffId = $staff->id;
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

    public function detailGajiKaryawan($id)
    {
        // Validasi staff_id dari user yang login
        $userId = Auth::user()->id;
        $staffId = Staff::where('users_id', $userId)->value('id');

        if (!$staffId) {
            Log::error('Staff ID tidak ditemukan untuk user: ' . (Auth::check() ? Auth::user()->id : 'tidak login'));
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan hubungi admin.');
        }

        // Ambil data slip gaji dengan relasi
        $payroll = SlipGaji::with(['staff', 'cabang'])
            ->where('id', $id)
            ->firstOrFail();

        // Tambahkan konteks absen untuk penjelasan potongan
        $month = Carbon::parse($payroll->periode)->month;
        $year = Carbon::parse($payroll->periode)->year;
        $absenRecords = Absen::where('staff_id', $staffId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();


        $alphaDays = $absenRecords->where('status', 'A')->count();
        $izinDay     = $absenRecords->where('status', 'I')->count(); // Izin
        $offDays      = $absenRecords->where('status', 'O')->count(); // Off
        $sakitDays    = $absenRecords->where('status', 'S')->count(); // Sakit

        $izinDays = $izinDay + $offDays + $sakitDays;
        $terlambatDays = $absenRecords->where('status', 'T')->count();
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $dailyRate = $payroll->gaji_pokok / $daysInMonth;

        // Persiapan data untuk tampilan
        $payroll->absen_details = [
            'alpha_days' => $alphaDays,
            'izin_days' => $izinDays,
            'terlambat_days' => $terlambatDays,
            'expected_alpha_cut' => $alphaDays * $dailyRate,
            'expected_izin_cut' => ($alphaDays + $izinDays > 3) ? max(0, $izinDays - ($alphaDays + $izinDays - 3)) * $dailyRate : 0,
            'expected_terlambat_cut' => $terlambatDays * 10000,
        ];

        Log::info('Detail gaji untuk staff_id ' . $staffId . ' dengan ID ' . $id . ': ', $payroll->toArray());
        return view('slip.detail', compact('payroll', 'dailyRate'));
    }


    public function exportPdf(Request $request)
    {
        $payrolls = SlipGaji::query()
            ->when($request->month, fn($query) => $query->whereMonth('periode', $request->month))
            ->when($request->year, fn($query) => $query->whereYear('periode', $request->year))
            ->with(['staff', 'cabang'])
            ->get();

        $pdf = Pdf::loadView('slip.riwayat_penggajian_all_pdf', compact('payrolls'));
        return $pdf->download('riwayat-penggajian-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportPdfKaryawan(Request $request)
    {
        $payroll = SlipGaji::query()
            ->where('staff_id', Auth::user()->staff_id) // Filter for authenticated user
            ->when($request->month, fn($query) => $query->whereMonth('periode', $request->month))
            ->when($request->year, fn($query) => $query->whereYear('periode', $request->year))
            ->get();

        $pdf = Pdf::loadView('slip.riwayat_penggajian_karyawan_pdf', compact('payroll'));
        return $pdf->download('riwayat-penggajian-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportPdfKaryawanBulan($id)
    {
        $user = Auth::user()->id;
        $staff = \App\Models\Staff::where('users_id', $user)->first();
        $staffId = $staff->id;
        $payroll = SlipGaji::with(['staff', 'cabang'])
            ->where('staff_id', $staffId)
            ->findOrFail($id);


        // Load the single payroll PDF view
        $pdf = Pdf::loadView('slip.riwayat_penggajian_karyawan_pdf', compact('payroll'));

        // Set PDF options for better rendering
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'Arial',
        ]);

        // Download the PDF with a filename based on the period
        $periode = \Carbon\Carbon::parse($payroll->periode)->format('Y-m');
        return $pdf->download('slip-gaji-' . $periode . '.pdf');
    }
}
