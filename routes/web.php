<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\HOPController;
use App\Http\Controllers\HODController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProgramController;
use App\Livewire\CreateStructure;
use App\Livewire\ReviewStructure;
use App\Livewire\ViewStructure;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth', 'role:staff')->prefix('staff')->group(function () {
    Route::get('/dashboard',[StaffController::class,'index'])->name('staff.dashboard');
    Route::get('/download-structure/{id}', [PDFController::class, 'generatePDF'])->name('structure.pdf');
});


Route::middleware('auth', 'role:HOP')->prefix('hop')->group(function () {
    Route::get('/dashboard',[HOPController::class,'index'])->name('hop.dashboard');
    Route::get('/create-structure', CreateStructure::class)->name('create.structure');
    Route::get('duplicate-structure/{id}', [HOPController::class, 'duplicate'])->name('structure.duplicate');
Route::delete('/hop/destroy/{id}', [HOPcontroller::class, 'destroy'])->name('hop.destroy');
});

Route::middleware('auth', 'role:HOD')->prefix('hod')->group(function () {
    Route::get('/dashboard',[HODController::class,'index'])->name('hod.dashboard');
    Route::get('/review-structure/{id}', ReviewStructure::class)->name('review.structure');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('programs', ProgramController::class);

Route::post('/subjects/{id}/toggle-status', [SubjectController::class, 'toggleStatus'])->name('subjects.toggle-status');
Route::resource('subject', SubjectController::class);

Route::resource('structure', StructureController::class);

Route::post('/subjects/import', [SubjectController::class, 'import'])
    ->name('subjects.import');

require __DIR__.'/auth.php';


Route::get('/review-structure/{id}', ReviewStructure::class)->name('review.structure');

Route::get('/view-structure/{id}', ViewStructure::class)->name('program.view');

