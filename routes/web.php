<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\HOPController;
use App\Http\Controllers\HODController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StructureController;
use App\Livewire\CreateStructure;
use App\Livewire\ReviewStructure;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth', 'role:staff')->group(function () {
    Route::get('/staff/dashboard',[StaffController::class,'index'])->name('staff.dashboard');
});

Route::middleware('auth', 'role:HOP')->group(function () {
    Route::get('/hop/dashboard',[HOPController::class,'index'])->name('hop.dashboard');
});

Route::middleware('auth', 'role:HOD')->group(function () {
    Route::get('/hod/dashboard',[HODController::class,'index'])->name('hod.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('subject', SubjectController::class);

Route::resource('structure', StructureController::class);

Route::post('/subjects/import', [SubjectController::class, 'import'])
    ->name('subjects.import');

require __DIR__.'/auth.php';

Route::get('/create-structure', CreateStructure::class);
Route::get('/review-structure/{id}', ReviewStructure::class)->name('review.show');