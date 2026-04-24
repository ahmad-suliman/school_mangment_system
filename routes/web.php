<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassSubjectTeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::resource('teachers',TeacherController::class);
    Route::resource('classes',ClassesController::class);
    Route::resource('subjects',SubjectController::class);
    Route::resource('class-subject-teachers',ClassSubjectTeacherController::class);
    Route::resource('grades', GradeController::class);

    // Admin can fully manage attendance
    Route::resource('attendance', AttendanceController::class)->except(['create','store']);

});


/*
|--------------------------------------------------------------------------
| TEACHER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

    Route::get('/dashboard',[DashboardController::class,'teacherDashboard'])->name('dashboard');

    // Attendance (teacher only create/store)
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('attendance/load', [AttendanceController::class, 'loadStudents'])->name('attendance.load');
    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

    // Grades
    Route::resource('grades', GradeController::class)->only(['index','create','store']);

});


/*
|--------------------------------------------------------------------------
| SHARED (ADMIN + TEACHER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin|teacher'])->group(function () {

    Route::resource('students',StudentController::class);

});
Route::middleware(['auth','role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

    Route::get('/dashboard',[DashboardController::class,'studentDashboard'])->name('dashboard');

    Route::get('/grades',[GradeController::class,'index'])->name('grades.index');

    Route::get('/attendance',[AttendanceController::class,'index'])->name('attendance.index');

    Route::get('/subjects',[SubjectController::class,'index'])->name('subjects.index');

});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
