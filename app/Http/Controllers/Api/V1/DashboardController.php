<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Class_subject_teacher;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses  = Classes::count();

        $totalAttendance = Attendance::count();
        $presentCount = Attendance::where('status', 'present')->whereDate('date', today())->count();
        $absentCount  = Attendance::where('status', 'absent')->whereDate('date', today())->count();
        $lateCount    = Attendance::where('status', 'late')->count();
        $attendanceRate = $totalAttendance > 0
            ? round(($presentCount / $totalAttendance) * 100)
            : 0;

        $latestStudents = Student::with('user', 'classroom')->latest()->take(5)->get();

        $assignments = Class_subject_teacher::with(['classroom', 'subject', 'teacher.user'])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'total_students'   => $totalStudents,
            'total_teachers'   => $totalTeachers,
            'total_classes'    => $totalClasses,
            'attendance_rate'  => $attendanceRate,
            'present_count'    => $presentCount,
            'absent_count'     => $absentCount,
            'late_count'       => $lateCount,
            'latest_students'  => $latestStudents,
            'assignments'      => $assignments,
        ]);
    }
    public function teacherDashboard()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $assignments = Class_subject_teacher::where('teacher_id', $teacher->id)
            ->with(['classroom', 'subject'])
            ->get();

        return response()->json([
            'assignments'       => $assignments,
            'total_classes'     => $assignments->pluck('class_id')->unique()->count(),
            'total_subjects'    => $assignments->pluck('subject_id')->unique()->count(),
            'total_students'    => Student::whereIn('class_id', $assignments->pluck('class_id'))->count(),
            'today_attendance'  => Attendance::where('teacher_id', $teacher->id)
                ->whereDate('date', today())
                ->count(),
        ]);
    }
    public function studentDashboard()
    {
        $student = auth()->user()->student;

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $subjects = Class_subject_teacher::with('subject')
            ->where('class_id', $student->class_id)
            ->get()
            ->pluck('subject')
            ->unique('id')
            ->values();

        $attendanceQuery = Attendance::where('student_id', $student->id)->whereDate('date', today());
        $totalAttendance = $attendanceQuery->count();
        $present = (clone $attendanceQuery)->where('status', 'present')->count();
        $attendanceRate = $totalAttendance > 0 ? round(($present / $totalAttendance) * 100) : 0;

        $grades = Grade::with('subject')->where('student_id', $student->id)->get();
        $averageGrade = $grades->count() > 0 ? round($grades->avg('marks'), 2) : 0;

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

        return response()->json([
            'student'           => $student,
            'subjects'          => $subjects,
            'subjects_count'    => $subjects->count(),
            'attendance_rate'   => $attendanceRate,
            'average_grade'     => $averageGrade,
            'grades'            => $grades,
            'recent_attendance' => $recentAttendance,
            'recent_grades'     => $recentGrades,
        ]);
    }
}
