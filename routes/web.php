<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\PengajuanKronologiController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:admin,kepala'])->group(function () {
    Route::get('/staff', [StaffController::class, 'view'])->name('staff.view');
    Route::get('/staff/addView', [StaffController::class, 'addView'])->name('staff.addView');
    Route::post('/staff/add', [StaffController::class, 'add'])->name('staff.add');
    Route::get('/staff/editView/{id}', [StaffController::class, 'editView'])->name('staff.editView');
    Route::patch('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');

    Route::get('/pengajuan/kronologi', [PengajuanKronologiController::class, 'view'])->name('kronologi.view');
    Route::post('/pengajuan/kronologi/validasi/{id}', [PengajuanKronologiController::class, 'validasi'])->name('kronologi.validasi');

});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/staff/userForm/{id}', [StaffController::class, 'userForm'])->name('staff.userForm');
    Route::post('/staff/saveUser/{id}', [StaffController::class, 'saveUser'])->name('staff.saveUser');

    Route::get('/cabang', [CabangController::class, 'view'])->name('cabang.view');
    Route::get('/cabang/addView', [CabangController::class, 'addView'])->name('cabang.addView');
    Route::post('/cabang/add', [CabangController::class, 'add'])->name('cabang.add');
    Route::get('/cabang/editView/{id}', [CabangController::class, 'editView'])->name('cabang.editView');
    Route::patch('/cabang/edit/{id}', [CabangController::class, 'edit'])->name('cabang.edit');

    Route::get('/jabatan', [JabatanController::class, 'view'])->name('jabatan.view');
    Route::get('/jabatan/addView', [JabatanController::class, 'addView'])->name('jabatan.addView');
    Route::post('/jabatan/add', [JabatanController::class, 'add'])->name('jabatan.add');
    Route::get('/jabatan/editView/{id}', [JabatanController::class, 'editView'])->name('jabatan.editView');
    Route::patch('/jabatan/edit/{id}', [JabatanController::class, 'edit'])->name('jabatan.edit');

    Route::get('/pengajuan/izin', [PengajuanIzinController::class, 'view'])->name('pengajuanizin.view');
    
});

Route::middleware(['auth', 'role:admin,kepala,karyawan'])->group(function () {
    Route::get('/pengajuan/izin/addView', [PengajuanIzinController::class, 'addView'])->name('pengajuanizin.addView');
    Route::post('/pengajuan/izin/add', [PengajuanIzinController::class, 'add'])->name('pengajuanizin.add');
    Route::get('/pengajuan/izin/riwayat', [PengajuanIzinController::class, 'riwayat'])->middleware(['auth'])->name('pengajuanizin.riwayat');
    Route::get('/pengajuan/izin/{id}', [PengajuanIzinController::class, 'detail'])->name('pengajuanizin.detail');
    Route::post('/pengajuan/izin/validasi/{id}', [PengajuanIzinController::class, 'validasi'])->name('pengajuanizin.validasi');

    Route::get('/pengajuan/kronologi/addView', [PengajuanKronologiController::class, 'addView'])->name('kronologi.addView');
    Route::post('/pengajuan/kronologi/add', [PengajuanKronologiController::class, 'add'])->name('kronologi.add');
    Route::get('/pengajuan/kronologi/riwayat', [PengajuanKronologiController::class, 'riwayat'])->name('kronologi.riwayat');
    Route::get('/pengajuan/kronologi/{id}', [PengajuanKronologiController::class, 'detail'])->name('kronologi.detail');

});



require __DIR__.'/auth.php';
