<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassSubjectTeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';
Route::get('/', function () {
    return view('welcome');
})->name('home');
//admin area

Route::middleware(['auth','role:admin'])->prefix('admin')->group(function (){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::resource('teachers',TeacherController::class);
    Route::resource('classes',ClassesController::class)->only(['index','create','store','edit','update','destroy']);
    Route::resource('subjects',SubjectController::class)->only(['index','create','store','edit','update','destroy']);
    Route::resource('class-subject-teachers',ClassSubjectTeacherController::class);
    Route::resource('grades', GradeController::class);
    });

Route::middleware(['auth','role:admin|teacher'])->group(function (){
    Route::resource('students',StudentController::class);
});
Route::middleware(['auth'])->group(function () {

    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');

    Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');

    Route::post('attendance/load', [AttendanceController::class, 'loadStudents'])->name('attendance.load');

    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

    Route::get('attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');

    Route::put('attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');

    Route::delete('attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

});
Route::middleware('auth')->group(function () {
      Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


