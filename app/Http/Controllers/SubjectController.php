<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Models\Subject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',Subject::class);

        //if user student he see just his subject
        if (auth()->user()->hasRole('student')) {
            $student = auth()->user()->student;
            $subjects = Subject::whereHas('classSubjectTeachers', function ($q) use ($student) {
            $q->where('class_id', $student->class_id);
        })->paginate(10);

        } else {
            //else user admin can see all subjects
            $subjects = Subject::paginate(10);
        }

        return view('Admin.Subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Subject::class);
        return view('Admin.Subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $this->authorize('create',Subject::class);
        $data = $request->validated();
        Subject::create([
            'subject_name' => $data['subject_name'],
            'subject_code' => strtoupper($data['subject_code']),
        ]);
        return redirect()->route('admin.subjects.index')->with('success', 'Subject Added Successfuly!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findorfail($id);
        $this->authorize('update',$subject);
        return view('Admin.Subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSubjectRequest $request, Subject $subject)
    {
        $this->authorize('update',$subject);
        $data = $request->validated();
        $subject->update([
            'subject_name' => $data['subject_name'],
            'subject_code' => strtoupper($data['subject_code']),
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findorfail($id);
        $this->authorize('delete',$subject);
        $subject->delete();
        return back()->with('danger', 'Subject Deletet!');
    }
}
