<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Class_subject_teacher;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function index()
    {
        if (auth()->user()->hasRole('student')) {

            $student = auth()->user()->student;

            $attendances = Attendance::with('subject')
                ->where('student_id', $student->id)
                ->latest()
                ->get();
        } elseif (auth()->user()->hasRole('teacher')) {

            $teacher = auth()->user()->teacher;

            $attendances = Attendance::with('student.user', 'subject')
                ->where('teacher_id', $teacher->id)
                ->latest()
                ->get();
        } else {
            // admin
            $attendances = Attendance::with('student.user', 'teacher.user', 'subject')
                ->latest()
                ->get();
        }

        return view('Admin.Attendance.index', compact('attendances'));
    }
    public function create()
    {
        $classes = Classes::all();

        if (auth()->user()->hasRole('admin')) {
            $teachers = Teacher::all();
            return view('Admin.Attendance.create', compact('classes', 'teachers'));
        }

        return view('Admin.Attendance.create', compact('classes'));
    }

    public function loadStudents(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
        ]);

        $classes = Classes::all();

        $students = Student::with('user')
            ->where('class_id', $request->class_id)
            ->get();

        // ✅ TEACHER
        if (auth()->user()->hasRole('teacher')) {

            $teacher = auth()->user()->teacher;

            if (!$teacher) {
                abort(403, 'Teacher not found');
            }

            $subjects = Class_subject_teacher::where('teacher_id', $teacher->id)
                ->where('class_id', $request->class_id)
                ->with('subject')
                ->get()
                ->pluck('subject');

            return view('Admin.Attendance.create', [
                'classes' => $classes,
                'students' => $students,
                'subjects' => $subjects,
                'class_id' => $request->class_id,
                'date' => $request->date,
            ]);
        }

        // ✅ ADMIN
        return view('Admin.Attendance.create', [
            'classes' => $classes,
            'students' => $students,
            'subjects' => Subject::all(),
            'teachers' => Teacher::with('user')->get(),
            'class_id' => $request->class_id,
            'date' => $request->date,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        if (auth()->user()->hasRole('teacher')) {

            $teacher = auth()->user()->teacher;

            if (!$teacher) {
                return back()->with('danger', 'Teacher profile not found.');
            }

            $teacher_id = $teacher->id;
        } else {
            $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
            ]);

            $teacher_id = $request->teacher_id;
        }
        if (auth()->user()->hasRole('teacher')) {

            $allowed = \App\Models\Class_subject_teacher::where([
                'teacher_id' => $teacher_id,
                'subject_id' => $request->subject_id,
                'class_id' => $request->class_id,
            ])->exists();

            if (!$allowed) {
                return back()->with('danger', 'You are not allowed to take attendance for this subject.');
            }
        }

        $exists = Attendance::where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->where('date', $request->date)
            ->exists();

        if ($exists) {
            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('admin.attendance.create')->withInput()
                    ->with('danger', 'Attendance already taken for this subject today.');
            } else {
                return redirect()->route('teacher.attendance.create')->withInput()
                    ->with('danger', 'Attendance already taken for this subject today.');
            }
        }


        foreach ($request->attendance as $student_id => $status) {

            Attendance::create([
                'student_id' => $student_id,
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'teacher_id' => $teacher_id,
                'date' => $request->date,
                'status' => $status,
            ]);
        }
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.attendance.index')
                ->with('success', 'Attendance saved successfully');
        } else {
            return redirect()->route('teacher.attendance.index')
                ->with('success', 'Attendance saved successfully');
        }
    }

    public function edit($id)
    {
        $attendance = Attendance::with('student.user')->findOrFail($id);

        return view('Admin.Attendance.edit', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'status' => $request->status,
        ]);

        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.attendance.index')
                ->with('success', 'Attendance updated successfully');
        } else {
            return redirect()->route('teacher.attendance.index')
                ->with('success', 'Attendance updated successfully');
        }
    }

    public function destroy($id)
    {
        if (auth()->user()->hasRole('admin')) {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();

            return back()->with('success', 'Attendance deleted successfully');
        } else {
            abort(403);
        }
    }
}
