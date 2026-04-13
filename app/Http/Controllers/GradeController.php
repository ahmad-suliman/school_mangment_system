<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with(['student.user','subject','teacher.user'])
                ->latest()
                ->paginate(10);

            return view('Admin.Grade.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::with('user')->get();
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();

        return view('Admin.Grade.create', compact('students', 'subjects', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'marks' => 'required|numeric|min:0|max:100',
        ]);

        Grade::create($request->only([
            'student_id',
            'subject_id',
            'teacher_id',
            'marks'
        ]));

        return redirect()->back()
            ->with('success', 'Grade added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $grade = Grade::findOrFail($id);

        return view('Admin.Grade.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'marks' => 'required|numeric|min:0|max:100',
        ]);

        $grade = Grade::findOrFail($id);
        $grade->update([
            'marks' => $request->marks
        ]);

        return redirect()->route('grades.index')
            ->with('success','Grade updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      Grade::findOrFail($id)->delete();

        return back()->with('success','Deleted successfully');
    }
}
