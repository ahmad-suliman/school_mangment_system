<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassSubjectTeacherRequest;
use App\Models\Class_subject_teacher;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassSubjectTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    $assignments = Class_subject_teacher::with([
        'classroom',
        'subject',
        'teacher.user',
    ])->latest()->paginate(10);

    return view('Admin.ClassSubjectTeacher.index', compact('assignments'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classes::all();
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        return view('Admin.ClassSubjectTeacher.create',compact('classes','subjects','teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassSubjectTeacherRequest $request)
    {

        Class_subject_teacher::create($request->validated());

        return redirect()->route('admin.class-subject-teachers.index')->with('success','subject assign successfuly!');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classes = Classes::all();
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        $classSubjectTeacher = Class_subject_teacher::findorfail($id);
        return view('Admin.ClassSubjectTeacher.edit',compact('classes','subjects','teachers','classSubjectTeacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassSubjectTeacherRequest $request, string $id)
    {
        $assignment = Class_subject_teacher::findorfail($id);
        $assignment->update($request->validated());
        return redirect()->route('admin.class-subject-teachers.index')->with('success','Assignment Edited Successfuly!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        $assignment = Class_subject_teacher::findorfail($id)->delete();
        return redirect()->back()->with('danger','Assignment Was Deleted');
    }
}
