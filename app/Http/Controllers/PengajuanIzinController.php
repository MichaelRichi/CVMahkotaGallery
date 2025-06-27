<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanIzin;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Absen;
use App\Models\DetailPengajuanIzin;

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

    public function addView()
    {
        return view('pengajuan_izin.add');
    }

    public function add(Request $request)
    {
        $request->validate([
            'detail' => 'required|array|min:1',
            'detail.*.tanggal' => 'required|date',
            'detail.*.status' => 'required|string|in:I,S,O,C',
            'detail.*.keterangan' => 'nullable|string|max:255',
        ]);

        $staff = Staff::where('users_id', Auth::id())->firstOrFail();

        $pengajuan = PengajuanIzin::create([
            'staff_id' => $staff->id,
            'validasi_admin' => null,
            'admin_id' => null
        ]);

        foreach ($request->detail as $item) {
            DetailPengajuanIzin::create([
                'pengajuan_izin_id' => $pengajuan->id,
                'tanggal' => $item['tanggal'],
                'status' => $item['status'],
                'keterangan' => $item['keterangan'],
            ]);
        }
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('pengajuanizin.view')->with('success', 'Pengajuan berhasil ditambahkan.');
        }else{
            return redirect()->route('dashboard')->with('success', 'Pengajuan berhasil ditambahkan.');
        }
        
    }

    public function detail($id)
    {
        $user = Auth::user();
        $pengajuan = PengajuanIzin::with(['staff', 'admin', 'detail_pengajuan_izin'])->findOrFail($id);

        if ($user->role !== 'admin') {
            $staff = $user->staff;

            // Kalau user belum punya relasi staff atau bukan pemilik pengajuan ini, tolak
            if (!$staff || $pengajuan->staff_id !== $staff->id) {
                abort(403, 'Anda tidak diizinkan mengakses data ini.');
            }
        }

        return view('pengajuan_izin.detail', compact('pengajuan'));
    }
    public function validasi(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:terima,tolak',
        ]);

        $pengajuan = PengajuanIzin::with('detail_pengajuan_izin')->findOrFail($id);

        $staff = auth()->user()->staff;
        if (!$staff) {
            abort(403, 'User ini tidak terhubung dengan data staff.');
        }

        $pengajuan->validasi_admin = $request->aksi === 'terima' ? 1 : 0;
        $pengajuan->admin_id = $staff->id;
        $pengajuan->save();

        if ($request->aksi === 'terima') {
            $staffIzin = $pengajuan->staff;
            $cabangId = $staffIzin->staffCabang()->where('is_active', true)->value('cabang_id');

            if ($cabangId) {
                foreach ($pengajuan->detail_pengajuan_izin as $detail) {
                    // Hapus data absen yang sudah ada di tanggal itu
                    Absen::where('staff_id', $staffIzin->id)
                        ->whereDate('tanggal', $detail->tanggal)
                        ->delete();

                    // Masukkan data absen dari pengajuan
                    Absen::create([
                        'staff_id' => $staffIzin->id,
                        'cabang_id' => $cabangId,
                        'tanggal' => $detail->tanggal,
                        'status' => $detail->status,
                        'keterangan' => $detail->keterangan,
                    ]);
                }
            }
        }

        return redirect()->route('pengajuanizin.detail', $id)->with('success', 'Pengajuan telah divalidasi.');
    }


    public function riwayat()
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            abort(403, 'User belum terhubung dengan data staff.');
        }

        $pengajuan = PengajuanIzin::with('detail_pengajuan_izin')
            ->where('staff_id', $staff->id)
            ->latest()
            ->get();

        return view('pengajuan_izin.riwayat', compact('pengajuan'));
    }


}
