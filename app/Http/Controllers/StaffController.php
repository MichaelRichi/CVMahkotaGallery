<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Staff;

class StaffController extends Controller
{
    public function view(Request $request)
    {
        $dataStaff = Staff::all();

        return view('staff.index', compact('dataStaff'));
    }
}
