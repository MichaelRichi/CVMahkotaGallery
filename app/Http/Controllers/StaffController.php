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
        $cabang = Cabang::all();
        $jabatan = Jabatan::all();

        return view('staff.index', compact('staff', 'cabang', 'jabatan'));
    }
}
