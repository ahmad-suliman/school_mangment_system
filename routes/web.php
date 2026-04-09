<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';
Route::get('/', function () {
    return view('welcome');
})->name('home');
//admin area

Route::middleware(['auth','role:admin'])->prefix('admin')->group(function (){
    Route::get('/dashboard',function (){
        return view('Admin.dashboard');
    })->name('dashboard');
    Route::resource('teachers',TeacherController::class);
    Route::resource('classes',ClassesController::class)->only(['index','create','store','edit','update','destroy']);
    Route::resource('subjects',SubjectController::class)->only(['index','create','store','edit','update','destroy']);
});

Route::middleware(['auth','role:admin|teacher'])->group(function (){
    Route::resource('students',StudentController::class);
});
Route::middleware('auth')->group(function () {
      Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


