<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;

class CabangController extends Controller
{
    public function view(Request $request)
    {
        $filter = $request->query('filter', 'aktif');
        $dataCabang = Cabang::query();
        if ($filter === 'aktif') {
            $dataCabang->where('is_active', 1);
        } elseif ($filter === 'nonaktif') {
            $dataCabang->where('is_active', 0);
        }
        $dataCabang = $dataCabang->get();
        return view('cabang.index', compact('dataCabang', 'filter'));
    }
}
