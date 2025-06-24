<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanKronologi;
use Illuminate\Support\Facades\Auth;

class PengajuanKronologiController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('status', 'semua');

        $query = PengajuanKronologi::with('staff');

        if ($filter === 'menunggu') {
            $query->where(function ($q) {
                $q->whereNull('validasi_admin')->orWhereNull('validasi_kepalacabang');
            });
        } elseif ($filter === 'ditolak') {
            $query->where(function ($q) {
                $q->where('validasi_admin', 0)->orWhere('validasi_kepalacabang', 0);
            });
        } elseif ($filter === 'diterima') {
            $query->where('validasi_admin', 1)->where('validasi_kepalacabang', 1);
        }

        $pengajuan = $query->latest()->get();

        return view('pengajuan_kronologi.index', compact('pengajuan', 'filter'));
    }
    public function addView()
    {
        return view('pengajuan_kronologi.add');
    }
    public function add(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'nama_barang' => 'required',
            'penjelasan' => 'required',
            'harga_barang' => 'required|numeric',
        ]);

        $staff = Auth::user()->staff;
        PengajuanKronologi::create([
            'staff_id' => $staff->id,
            'cabang_id' => $staff->cabang()->first()->id,
            'judul' => $request->judul,
            'nama_barang' => $request->nama_barang,
            'penjelasan' => $request->penjelasan,
            'harga_barang' => $request->harga_barang,
        ]);

        return redirect()->route('kronologi.index')->with('success', 'Pengajuan berhasil diajukan.');
    }
}
