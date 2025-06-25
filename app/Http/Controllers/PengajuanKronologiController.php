<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanKronologi;
use App\Models\Hutang;
use App\Models\DetailHutang;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PengajuanKronologiController extends Controller
{
    public function view(Request $request)
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
            'periode_pelunasan' =>'required',
        ]);

        $staff = Auth::user()->staff;
        PengajuanKronologi::create([
            'staff_id' => $staff->id,
            'cabang_id' => $staff->cabang()->first()->id,
            'judul' => $request->judul,
            'nama_barang' => $request->nama_barang,
            'penjelasan' => $request->penjelasan,
            'harga_barang' => $request->harga_barang,
            'periode_pelunasan' => $request->periode_pelunasan,
        ]);        

        return redirect()->route('kronologi.view')->with('success', 'Pengajuan berhasil diajukan.');
    }
    public function detail($id)
    {
        $pengajuan = PengajuanKronologi::with(['staff', 'cabang', 'kepala', 'admin'])->findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'karyawan' && $pengajuan->staff->users_id !== $user->id) {
            abort(403);
        }

        return view('pengajuan_kronologi.detail', compact('pengajuan'));
    }
    public function validasi(Request $request, $id)
    {
        $request->validate(['aksi' => 'required|in:terima,tolak']);
        $pengajuan = PengajuanKronologi::findOrFail($id);
        $staff = Auth::user()->staff;
        $role = Auth::user()->role;

        if ($role === 'kepala') {
            $pengajuan->update([
                'validasi_kepalacabang' => $request->aksi === 'terima' ? 1 : 0,
                'kepala_id' => $staff->id,
            ]);
        } elseif ($role === 'admin') {
            $pengajuan->update([
                'validasi_admin' => $request->aksi === 'terima' ? 1 : 0,
                'admin_id' => $staff->id,
            ]);

            // Cek jika validasi kepala cabang sudah OK dan admin juga menerima
            if ($request->aksi === 'terima' && $pengajuan->validasi_kepalacabang === 1) {
                // Ambil staff pengaju
                $staffPengaju = $pengajuan->staff;

                // Set start pelunasan bulan depan
                $startPelunasan = Carbon::now()->addMonthNoOverflow()->startOfMonth();

                // Buat Hutang
                $hutangbaru = Hutang::create([
                    'staff_id' => $staffPengaju->id,
                    'jumlah_hutang'=> $pengajuan->harga_barang,
                    'periode_pelunasan' => $pengajuan->periode_pelunasan,
                    'start_pelunasan'=> $startPelunasan,
                    'jenis' =>'kronologi',
                    'kronologi_id'=> $pengajuan->id,
                ]);

                // Hitung cicilan per bulan
                $jumlahPerBulan = round($pengajuan->harga_barang / $pengajuan->periode_pelunasan, 2);

                // Buat detail hutang per bulan
                for ($i = 0; $i < $pengajuan->periode_pelunasan; $i++) {
                    DetailHutang::create([
                        'hutang_id' => $hutangbaru->id,
                        'jumlah_hutang' => $jumlahPerBulan,
                        'tanggal_pelunasan' => $startPelunasan->copy()->addMonths($i),
                    ]);
                }
            }
        } else {
            abort(403);
        }

        return redirect()->route('kronologi.detail', $id)->with('success', 'Validasi berhasil dilakukan.');
    }

    public function riwayat()
    {
        $staff = Auth::user()->staff;
        $pengajuan = PengajuanKronologi::where('staff_id', $staff->id)->latest()->get();
        return view('pengajuan_kronologi.riwayat', compact('pengajuan'));
    }

}
