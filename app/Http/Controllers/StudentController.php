<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Classes;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Builder\Class_;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['user', 'classroom'])->paginate(10);
        return view('Student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classroom = Classes::select('id', 'class_name', 'section')->orderBy('section')->get();
        $student_id = Student::count();
        return view('Student.create', compact('classroom', 'student_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {

        $data = $request->validated();
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('students', 'public');
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => $data['status'],
            'profile_photo' => $photoPath,
        ]);
        $user->assignRole('student');
        Student::create([
            'user_id' => $user->id,
            'student_id' => $data['student_id'],
            'class_id' => $data['class_id'],
            'phone' => $data['phone'],
            'birth_date' => $data['birth_date'],
            'address' => $data['address'],
            'guardian_name' => $data['guardian_name'],
            'guardian_phone' => $data['guardian_phone'],
        ]);
        return redirect()->route('students.index')->with('success', 'Student Added Successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Student $student)
    {
        $student->load('user', 'classroom');
        return view('Student.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classroom = Classes::select('id', 'class_name', 'section')->orderBy('section')->get();
        $student = Student::with(['user',])->findOrFail($id);
        return view('Student.edit', compact('student', 'classroom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        $data = $request->validated();
        $user_id = $request->user_id;
        $user = User::findorfail($user_id)->update([
            'name' => $data['name'],
        ]);
        Student::findorfail($id)->update([
            'class_id' => $data['class_id'],
            'phone' => $data['phone'],
            'birth_date' => $data['birth_date'],
            'address' => $data['address'],
            'guardian_name' => $data['guardian_name'],
            'guardian_phone' => $data['guardian_phone'],
        ]);
        return redirect()->route('students.index')->with('success', 'Student Updated Successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findorfail($id)->delete();
        return back()->with('danger', 'Student Delete It!');
    }
}
