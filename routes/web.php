<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/staff', [App\Http\Controllers\StaffController::class, 'index'])->name('staff.index');

