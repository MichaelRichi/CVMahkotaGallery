<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Cabang;
use App\Models\Jabatan;

class StaffController extends Controller
{
    public function view(Request $request)
    {
        // $query = Staff::with(['cabang', 'jabatan']);
        $query = Staff::with(['cabang' => function ($q) {
        $q->orderByDesc('staff_cabang.created_at');
        },'jabatan' => function ($q) {
        $q->orderByDesc('staff_jabatan.created_at');
        }]);

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('cabang_id')) {
            // $query->where('cabang_id', $request->cabang_id);
            $query->whereHas('cabang', function ($q) use ($request) {
                $q->where('cabang.id', $request->cabang_id);
            });
        }

        if ($request->filled('jabatan_id')) {
            // $query->where('jabatan_id', $request->jabatan_id);
            $query->whereHas('jabatan', function ($q) use ($request) {
                $q->where('jabatan.id', $request->jabatan_id);
            });
        }

        $staff = $query->get();
        $cabang = Cabang::where('is_active','=','1')->get();
        $jabatan = Jabatan::where('is_active','=','1')->get();

        return view('staff.index', compact('staff', 'cabang', 'jabatan'));
    }
    public function addView()
    {
        $cabang = Cabang::where('is_active','=','1')->get();
        $jabatan = Jabatan::where('is_active','=','1')->get();
        return view('staff.add',compact('cabang','jabatan'));
    }
    public function add(Request $request)
    {
        $validated = $request->validate([
            'NIK'             => 'required|unique:staff,NIK',
            'nama'            => 'required',
            'JK'              => 'required|in:L,P',
            'TTL'             => 'required|date',
            'notel'           => 'required',
            'alamat'          => 'required',
            'tgl_masuk'       => 'required|date',
            'tgl_keluar'      => 'nullable|date|after_or_equal:tgl_masuk',
            'gaji_pokok'      => 'required|numeric',
            'gaji_tunjangan'  => 'required|numeric',
            'is_active'       => 'required|boolean',
            'cabang_id'       => 'required|exists:cabang,id',
            'jabatan_id'      => 'required|exists:jabatan,id',
        ]);

        $staff = Staff::create($request->only([
            'NIK',
            'nama',
            'JK',
            'TTL',
            'notel',
            'alamat',
            'tgl_masuk',
            'tgl_keluar', 
            'gaji_pokok',
            'gaji_tunjangan',
            'is_active',
        ]));

        // Tambah relasi cabang aktif
        $staff->cabang()->attach($request->cabang_id, [
            'is_active'       => true,
            'tanggal_mulai'   => $request->tgl_masuk,
            'tanggal_selesai' => null,
        ]);

        // Tambah relasi jabatan aktif + tanggal masuk sebagai tanggal_mulai
        $staff->jabatan()->attach($request->jabatan_id, [
            'is_active'       => true,
            'tanggal_mulai'   => $request->tgl_masuk,
            'tanggal_selesai' => null,
        ]);

        return redirect()->route('staff.view')->with('success', 'Staff berhasil ditambahkan.');
    }

}
