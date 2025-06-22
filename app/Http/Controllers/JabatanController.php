<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function view(Request $request)
    {
        $filter = $request->query('filter', 'aktif');
        $dataJabatan = Jabatan::query();
        if ($filter === 'aktif') {
            $dataJabatan->where('is_active', 1);
        } elseif ($filter === 'nonaktif') {
            $dataJabatan->where('is_active', 0);
        }
        $dataJabatan = $dataJabatan->get();
        return view('jabatan.index', compact('dataJabatan', 'filter'));
    }
}
