<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanIzin;

class PengajuanIzinController extends Controller
{
    public function view(Request $request)
    {
        // Ambil nilai filter dari query string, defaultnya 'semua'
        $filter = $request->query('filter', 'semua');

        // Query dasar
        $query = PengajuanIzin::with(['staff', 'admin']);

        // Terapkan filter jika ada
        if ($filter === 'menunggu') {
            $query->whereNull('validasi_admin');
        } elseif ($filter === 'acc') {
            $query->where('validasi_admin', 1);
        } elseif ($filter === 'ditolak') {
            $query->where('validasi_admin', 0);
        }

        // Eksekusi query
        $dataPengajuan = $query->latest()->get();

        return view('pengajuan_izin.index', compact('dataPengajuan', 'filter'));
    }

}
