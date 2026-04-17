<?php

namespace App\Http\Controllers;

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
        if (auth()->user()->hasRole('teacher')) {

            $teacher_id = auth()->user()->teacher->id;

            $grades = Grade::with(['student.user', 'subject'])
                ->where('teacher_id', $teacher_id)
                ->latest()
                ->paginate(10);
        } else {

            $grades = Grade::with(['student.user', 'subject', 'teacher.user'])
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

            return view('Admin.Grade.create', compact('classes', 'subjects','students'));
        }

        // admin
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();

        return view('Admin.Grades.create', compact('classes', 'subjects', 'teachers','students'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|numeric|min:0|max:100',
        ]);

        // ================= GET TEACHER =================
        if (auth()->user()->hasRole('teacher')) {

            $teacher = auth()->user()->teacher;

            if (!$teacher) {
                return back()->with('danger', 'Teacher not found');
            }

            $teacher_id = $teacher->id;

            // 🔥 SECURITY: teacher can only add his subject
            $allowed = Class_subject_teacher::where([
                'teacher_id' => $teacher_id,
                'subject_id' => $request->subject_id
            ])->exists();

            if (!$allowed) {
                return back()->with('danger', 'You are not allowed for this subject');
            }
        } else {

            // admin must choose teacher
            $request->validate([
                'teacher_id' => 'required|exists:teachers,id'
            ]);

            $teacher_id = $request->teacher_id;
        }

        // ================= SAVE =================
        Grade::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $teacher_id,
            'marks' => $request->marks,
        ]);
        if(auth()->user()->hasRole('admin')){
             return redirect()->route('admin.grades.index')
                ->with('success', 'Grade added successfully');
        }else{
                return redirect()->route('teacher.grades.index')
                ->with('success', 'Grade added successfully');
        }

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
        if(auth()->user()->hasRole('admin')){
             return redirect()->route('admin.grades.index')
                ->with('success', 'Grade updated');
        }else{
                return redirect()->route('teacher.grades.index')
                ->with('success', 'Grade updated');
        }

    }

    public function destroy(string $id)
    {
        Grade::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully');
    }
}
