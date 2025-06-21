<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/staff', [App\Http\Controllers\StaffController::class, 'view'])->name('staff.view');
Route::get('/staff/addView', [App\Http\Controllers\StaffController::class, 'addView'])->name('staff.addView');
Route::post('/staff/add', [App\Http\Controllers\StaffController::class, 'add'])->name('staff.add');
