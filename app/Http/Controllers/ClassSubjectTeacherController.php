<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassSubjectTeacherRequest;
use App\Models\Class_subject_teacher;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ClassSubjectTeacherController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Class_subject_teacher::class);
        $search = $request->search;
        $assignments = Class_subject_teacher::with([
            'classroom',
            'subject',
            'teacher.user',
        ])->when($search,function ($query) use ($search){
            $query->orWhereHas('classroom',function ($q) use ($search){
                $q->where('class_name','like',"%$search%");
            })
            ->orWhereHas('subject',function ($q) use ($search){
                  $q->where('subject_code','like',"%$search%");
            })
            ->orWhereHas('teacher.user',function ($q) use ($search){
                  $q->where('name','like',"%$search%");
            });
        })
        ->latest()
        ->paginate(10);

        return view('Admin.ClassSubjectTeacher.index', compact('assignments'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Class_subject_teacher::class);
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
        $this->authorize('create',Class_subject_teacher::class);

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
        $this->authorize('update',$classSubjectTeacher);
        return view('Admin.ClassSubjectTeacher.edit',compact('classes','subjects','teachers','classSubjectTeacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassSubjectTeacherRequest $request, string $id)
    {
        $assignment = Class_subject_teacher::findorfail($id);
        $this->authorize('update',$assignment);
        $assignment->update($request->validated());
        return redirect()->route('admin.class-subject-teachers.index')->with('success','Assignment Edited Successfuly!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        $assignment = Class_subject_teacher::findorfail($id);
        $this->authorize('delete',$assignment);
        $assignment->delete();
        return redirect()->back()->with('danger','Assignment Was Deleted');
    }
}
