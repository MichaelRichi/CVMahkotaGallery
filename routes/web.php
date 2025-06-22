<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
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
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/staff/userForm/{id}', [StaffController::class, 'userForm'])->name('staff.userForm');
    Route::post('/staff/saveUser/{id}', [StaffController::class, 'saveUser'])->name('staff.saveUser');
});


require __DIR__.'/auth.php';
