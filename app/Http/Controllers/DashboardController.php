<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Class_subject_teacher;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = Classes::count();

        // Attendance percentage (simple real logic)
        $totalAttendance = Attendance::count();
        $presentCount = Attendance::where('status', 'present')->count();

        $attendanceRate = $totalAttendance > 0
            ? round(($presentCount / $totalAttendance) * 100)
            : 0;

        // Latest students
        $latestStudents = Student::with('user', 'classroom')
            ->latest()
            ->take(5)
            ->get();

        // Class-Subject-Teacher relations
        $assignments = Class_subject_teacher::with(['classroom', 'subject', 'teacher.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('Admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'attendanceRate',
            'latestStudents',
            'assignments'
        ));
    }
    public function teacherDashboard()
    {
        $teacher = auth()->user()->teacher;

        $assignments = \App\Models\Class_subject_teacher::where('teacher_id', $teacher->id)
            ->with(['classroom', 'subject'])
            ->get();

        return view('Teacher.dashboard', [
            'classes' => $assignments,
            'subjects' => $assignments,
            'totalClasses' => $assignments->pluck('class_id')->unique()->count(),
            'totalSubjects' => $assignments->pluck('subject_id')->unique()->count(),
            'totalStudents' => \App\Models\Student::whereIn('class_id', $assignments->pluck('class_id'))->count(),
            'todayAttendance' => \App\Models\Attendance::where('teacher_id', $teacher->id)
                ->whereDate('date', today())->count(),
        ]);
    }
    public function studentDashboard()
    {
        $student = auth()->user()->student;

        if (!$student) {
            abort(403, 'Student not found');
        }

        // ✅ Get subjects from class (CORRECT WAY)
        $subjects = Class_subject_teacher::with('subject')
            ->where('class_id', $student->class_id)
            ->get()
            ->pluck('subject')
            ->unique('id');

        $subjectsCount = $subjects->count();

        // ✅ Attendance (optimized)
        $attendanceQuery = Attendance::where('student_id', $student->id);

        $totalAttendance = $attendanceQuery->count();

        $present = (clone $attendanceQuery)
            ->where('status', 'present')
            ->count();

        $attendanceRate = $totalAttendance > 0
            ? round(($present / $totalAttendance) * 100)
            : 0;

        // ✅ Grades
        $grades = Grade::with('subject')
            ->where('student_id', $student->id)
            ->get();

        $averageGrade = $grades->count() > 0
            ? round($grades->avg('marks'), 2)
            : 0;

        // ✅ Recent activity
        $recentAttendance = Attendance::with('subject')
            ->where('student_id', $student->id)
            ->latest()
            ->take(5)
            ->get();

        $recentGrades = Grade::with('subject')
            ->where('student_id', $student->id)
            ->latest()
            ->take(5)
            ->get();

        return view('Student.dashboard', compact(
            'student',
            'subjects',
            'subjectsCount',
            'attendanceRate',
            'averageGrade',
            'grades',
            'recentAttendance',
            'recentGrades'
        ));
    }
}
