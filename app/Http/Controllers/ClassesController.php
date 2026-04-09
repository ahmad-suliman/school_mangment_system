<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Classes.index', ['classes' => Classes::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
            'academic_year' => ['required', 'regex:/^\d{4}-\d{4}$/'],
        ], [
            'academic_year.regex' => 'Academic year must be like 2025-2026',
        ]);

        Classes::create([
            'class_name' => $validated['class_name'],
            'section' => $validated['section'],
            'academic_year' => $validated['academic_year'],
        ]);

        return redirect()->back()->with('success', 'class add successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classes = Classes::findorfail($id);
        return view('Admin.Classes.edit', compact('classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
            'academic_year' => ['required', 'regex:/^\d{4}-\d{4}$/'],
        ], [
            'academic_year.regex' => 'Academic year must be like 2025-2026',
        ]);
        Classes::findorfail($id)->update([
            'class_name' => $validated['class_name'],
            'section' => $validated['section'],
            'academic_year' => $validated['academic_year'],
        ]);
        return redirect()->back()->with('success', 'class edit successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $classes = Classes::findorfail($id)->delete();
       return redirect()->back()->with('danger', 'class deleted successfuly');
    }
}
