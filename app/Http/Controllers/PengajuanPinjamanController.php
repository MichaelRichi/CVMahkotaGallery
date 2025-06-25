<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanPinjaman;
use App\Models\Hutang;
use Illuminate\Support\Facades\Auth;

class PengajuanPinjamanController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $data = $user->role === 'karyawan'
            ? PengajuanPinjaman::where('staff_id', $user->staff->id)->get()
            : PengajuanPinjaman::with('staff')->latest()->get();

        return view('pengajuan_pinjaman.index', compact('data'));
    }
    public function addView()
    {
        return view('pengajuan_pinjaman.add');
    }
    public function add(Request $request)
    {
        $request->validate([
            'jumlah_pinjaman' => 'required|numeric|min:1000',
            'periode_pelunasan' => 'required|integer|min:1',
            'start_pelunasan' => 'required|date',
            'alasan' => 'required|string',
        ]);

        PengajuanPinjaman::create([
            'staff_id' => Auth::user()->staff->id,
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'periode_pelunasan' => $request->periode_pelunasan,
            'start_pelunasan' => $request->start_pelunasan,
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('pinjaman.view')->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }
    public function validasi(Request $request, $id)
    {
        $request->validate(['aksi' => 'required|in:terima,tolak']);
        $pengajuan = PengajuanPinjaman::findOrFail($id);

        $pengajuan->update([
            'validasi_admin' => $request->aksi === 'terima' ? 1 : 0,
            'admin_id' => Auth::user()->staff->id,
        ]);

        if ($request->aksi === 'terima') {
            Hutang::create([
                'staff_id' => $pengajuan->staff_id,
                'jumlah_hutang' => $pengajuan->jumlah_pinjaman,
                'periode_pelunasan' => $pengajuan->periode_pelunasan,
                'start_pelunasan' => $pengajuan->start_pelunasan,
                'sisa_hutang' => $pengajuan->jumlah_pinjaman,
                'keterangan' => $pengajuan->alasan,
                'status' => 'ONGOING',
                'admin_id' => Auth::user()->staff->id,
            ]);
        }

        return redirect()->route('pinjaman.view')->with('success', 'Validasi berhasil dilakukan.');
    }
}
