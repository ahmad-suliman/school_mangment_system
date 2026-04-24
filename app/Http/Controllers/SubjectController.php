<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('student')) {

            $student = auth()->user()->student;

            $subjects = $student->classroom->subjects ?? collect();
        } else {
            $subjects = Subject::all();
        }

        return view('Admin.Subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:4|unique:subjects,subject_code',
        ]);
        Subject::create([
            'subject_name' => $validated['subject_name'],
            'subject_code' => strtoupper($validated['subject_code']),
        ]);
        return redirect()->route('admin.subjects.index')->with('success', 'Subject Added Successfuly!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findorfail($id);
        return view('Admin.Subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:4|unique:subjects,subject_code,' . $subject->id,
        ]);

        $subject->update([
            'subject_name' => $request->subject_name,
            'subject_code' => strtoupper($request->subject_code),
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findorfail($id)->delete();
        return back()->with('danger', 'Subject Deletet!');
    }
}
