<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Class_subject_teacher;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassSubjectTeacher;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX - Show Attendance List
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $attendances = Attendance::with([
            'student.user',
            'classroom',
            'subject',
            'teacher.user'
        ])->latest()->paginate(10);

        return view('Admin.Attendance.index', compact('attendances'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE - Show Form
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $classes = Classes::all();
        $teachers = Teacher::all();
        return view('Admin.Attendance.create', compact('classes','teachers'));
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD STUDENTS (Step 1)
    |--------------------------------------------------------------------------
    */
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


    if (auth()->user()->hasRole('teacher')) {

        $teacher_id = auth()->user()->teacher->id;

      $subjects = Class_subject_teacher::with('subject')
    ->where('teacher_id', $teacher_id)
    ->where('class_id', $request->class_id)
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


    $subjects = Subject::all();
    $teachers = Teacher::with('user')->get();

    return view('Admin.Attendance.create', [
        'classes' => $classes,
        'students' => $students,
        'subjects' => $subjects,
        'teachers' => $teachers,
        'class_id' => $request->class_id,
        'date' => $request->date,

    ]);
}

    /*
    |--------------------------------------------------------------------------
    | STORE - Save Attendance
    |--------------------------------------------------------------------------
    */
public function store(Request $request)
{

    // ✅ Validate basic data
    $request->validate([
        'class_id' => 'required|exists:classes,id',
        'subject_id' => 'required|exists:subjects,id',
        'date' => 'required|date',
        'attendance' => 'required|array',
    ]);

    // ✅ Get teacher_id based on role
    if (auth()->user()->hasRole('teacher')) {

        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return back()->with('danger', 'Teacher profile not found.');
        }

        $teacher_id = $teacher->id;

    } else {

        // admin must select teacher
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $teacher_id = $request->teacher_id;
    }

    // ✅ SECURITY: ensure teacher is allowed (only for teacher role)
    if (auth()->user()->hasRole('teacher')) {

        $allowed = \App\Models\ClassSubjectTeacher::where([
            'teacher_id' => $teacher_id,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
        ])->exists();

        if (!$allowed) {
            return back()->with('danger', 'You are not allowed to take attendance for this subject.');
        }
    }

    // ✅ Prevent duplicate attendance (same class + subject + date)
    $exists = Attendance::where('class_id', $request->class_id)
        ->where('subject_id', $request->subject_id)
        ->where('date', $request->date)
        ->exists();

    if ($exists) {
        return redirect()->route('attendance.create')->withInput()
            ->with('danger', 'Attendance already taken for this subject today.');
    }

    // ✅ Save attendance
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

return redirect()->route('attendance.create')
    ->with('success', 'Attendance saved successfully');
}

    /*
    |--------------------------------------------------------------------------
    | EDIT - Edit Attendance
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $attendance = Attendance::with('student.user')->findOrFail($id);

        return view('Admin.Attendance.edit', compact('attendance'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE - Update Attendance
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'status' => $request->status,
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return back()->with('success', 'Attendance deleted successfully');
    }
}
