<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\SlipGaji;
use App\Models\Absen;
use App\Models\Cabang;
use App\Models\PengajuanIzin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard berdasarkan peran pengguna
     */
    public function view(Request $request)
    {
        $staffId = Auth::user()->id;

        if (Auth::user()->role === 'admin') {
            // Data untuk admin
            $totalStaff = Staff::count();
            $activeRequests = PengajuanIzin::where('status', 'pending')->count();
            $activeBranches = Cabang::where('status', 'active')->count();

            return view('dashboard', [
                'totalStaff' => $totalStaff,
                'activeRequests' => $activeRequests,
                'activeBranches' => $activeBranches,
            ]);
        } else {
            // Data untuk karyawan
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Ringkasan Absen
            $absenSummary = Absen::where('staff_id', $staffId)
                ->whereMonth('tanggal', $currentMonth)
                ->whereYear('tanggal', $currentYear)
                ->get()
                ->groupBy('status')
                ->map(function ($group) {
                    return $group->count();
                })
                ->all();

            // Default values jika tidak ada data
            $absenSummary = array_merge([
                'H' => 0, // Hadir
                'A' => 0, // Alpha
                'T' => 0, // Terlambat
                'I' => 0, // Izin
            ], $absenSummary);

            // Ringkasan Gaji (gaji terakhir)
            $latestPayroll = SlipGaji::where('staff_id', $staffId)
                ->orderBy('periode', 'desc')
                ->first();

            $salarySummary = $latestPayroll ? [
                'gaji_pokok' => $latestPayroll->gaji_pokok,
                'gaji_bersih' => $latestPayroll->gaji_bersih,
            ] : ['gaji_pokok' => 0, 'gaji_bersih' => 0];

            return view('dashboard', [
                'absenSummary' => $absenSummary,
                'salarySummary' => $salarySummary,
            ]);
        }
    }
}
