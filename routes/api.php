<?php

use App\Http\Controllers\Api\V1\AnnouncementController;
use App\Http\Controllers\Api\V1\AttendanceController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ClassesController;
use App\Http\Controllers\Api\V1\ClassSubjectTeacherController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\GradeController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\ReportPdfController;
use App\Http\Controllers\Api\V1\StudentController;
use App\Http\Controllers\Api\V1\SubjectController;
use App\Http\Controllers\Api\V1\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
        Route::apiResource('students', StudentController::class)->names('api.students');
        Route::apiResource('teachers', TeacherController::class)->names('api.teachers');
        Route::apiResource('subjects', SubjectController::class)->except(['show'])->names('api.subjects');
        Route::get('/reports/students/pdf', [ReportPdfController::class, 'exportStudentsPdf']);
        Route::get('/reports/students/{student}/pdf', [ReportPdfController::class, 'exportStudentPdf']);
        Route::apiResource('grades',GradeController::class)->names('api.grades');
        Route::apiResource('assignments',ClassSubjectTeacherController::class)->names('api.assignments');
        Route::apiResource('classes',ClassesController::class)->except(['show'])->names('api.classes');
        Route::apiResource('announcements', AnnouncementController::class)->except(['create', 'edit'])->names('api.announcements');
        Route::middleware(['role:admin'])->get('admin/dashboard',[DashboardController::class,'index']);
        Route::middleware(['role:teacher'])->get('teacher/dashboard',[DashboardController::class,'teacherDashboard']);
        Route::middleware(['role:student'])->get('student/dashboard',[DashboardController::class,'studentDashboard']);
        Route::get('/attendance', [AttendanceController::class, 'index']);

        Route::middleware('role:teacher')->post('/attendance', [AttendanceController::class, 'store']);
        Route::middleware('role:admin')->put('/attendance/{attendance}', [AttendanceController::class, 'update']);
        Route::middleware('role:admin')->delete('/attendance/{attendance}', [AttendanceController::class, 'destroy']);

        Route::get('/profile', [ProfileController::class, 'show']);
        Route::post('/profile', [ProfileController::class, 'update']);
        Route::delete('/profile', [ProfileController::class, 'destroy']);
        Route::put('/profile/password', [ProfileController::class, 'updatePassword']);
    });
});
