<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeRequest;
use App\Models\Class_subject_teacher;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class GradeController extends Controller
{

    public function index()
    {
        if (auth()->user()->hasRole('student')) {

            $student = auth()->user()->student;

            $grades = Grade::with('subject')
                ->where('student_id', $student->id)
                ->latest()
                ->paginate(10);
        } elseif (auth()->user()->hasRole('teacher')) {

            $teacher = auth()->user()->teacher;

            $grades = Grade::with('student.user', 'subject')
                ->where('teacher_id', $teacher->id)
                ->latest()
                ->paginate(10);;
        } else {
            // admin
            $grades = Grade::with('student.user', 'subject', 'teacher.user')
                ->latest()
                ->paginate(10);
        }

        return view('Admin.Grade.index', compact('grades'));
    }

    public function create()
    {
        $classes = Classes::all();
        $students = Student::with('user')->get();

        // teacher
        if (auth()->user()->hasRole('teacher')) {

            $teacher = auth()->user()->teacher;

            $subjects = Class_subject_teacher::where('teacher_id', $teacher->id)
                ->with('subject')
                ->get()
                ->pluck('subject');

            return view('Admin.Grade.create', compact('classes', 'subjects', 'students'));
        }

        // admin
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();

        return view('Admin.Grade.create', compact('classes', 'subjects', 'teachers', 'students'));
    }


    public function store(StoreGradeRequest $request)
    {
        // 🎯 Resolve teacher_id
        if (auth()->user()->hasRole('teacher')) {

            $teacher = auth()->user()->teacher;

            if (!$teacher) {
                return redirect()->back()->with('danger', 'Teacher not found');
            }

            $teacher_id = $teacher->id;

            // 🔒 Security check
            $allowed = Class_subject_teacher::where([
                'teacher_id' => $teacher_id,
                'subject_id' => $request->subject_id
            ])->exists();

            if (!$allowed) {
                return redirect()->back()->with('danger', 'Not allowed for this subject');
            }
        } else {
            $teacher_id = $request->teacher_id;
        }

        // 🚫 Prevent duplicate grade (IMPORTANT)
        $exists = Grade::where([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
        ])->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Grade already exists for this student & subject');
        }

        // 💾 Save
        Grade::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $teacher_id,
            'marks'      => $request->marks,
        ]);

        // 🔁 Redirect
        return redirect()->route(
            auth()->user()->hasRole('admin')
                ? 'admin.grades.index'
                : 'teacher.grades.index'
        )->with('success', 'Grade added successfully');
    }


    public function edit(string $id)
    {
        $grade = Grade::findOrFail($id);

        return view('Admin.Grade.edit', compact('grade'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'marks' => 'required|numeric|min:0|max:100',
        ]);

        $grade = Grade::findOrFail($id);
        $grade->update([
            'marks' => $request->marks
        ]);
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.grades.index')
                ->with('success', 'Grade updated');
        } else {
            return redirect()->route('teacher.grades.index')
                ->with('success', 'Grade updated');
        }
    }

    public function destroy(string $id)
    {
        if (auth()->user()->hasRole('admin')) {
            Grade::findOrFail($id)->delete();

            return back()->with('success', 'Deleted successfully');
        } else {
            abort(403);
        }
    }
}
