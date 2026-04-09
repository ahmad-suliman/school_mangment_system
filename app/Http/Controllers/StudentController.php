<?php

namespace App\Http\Controllers;

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
        $students = Student::with(['user','classroom'])->paginate(10);
        return view('Student.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classroom = Classes::select('id','class_name','section')->orderBy('section')->get();
        $student_id =Student::count();
        return view('Student.create',compact('classroom','student_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
        //user table
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
        'status' => 'required|in:0,1',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        // Student table
        'student_id' => 'required|string|max:50|unique:students,student_id',
        'class_id' => 'required|exists:classes,id',
        'phone' => 'required|nullable|string|max:20',
        'birth_date'=>'required|date',
        'address' => 'required|nullable|string|max:500',
        'guardian_name' => 'required|nullable|string|max:255',
        'guardian_phone' => 'required|nullable|string|max:255',
        ]);
      $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('students', 'public');
        }
        $user = User::create([
            'name'=>$validated['name'],
            'email'=>$validated['email'],
            'password'=>Hash::make($validated['password']),
            'status'=>$validated['status'],
            'profile_photo'=>$photoPath,
        ]);
        $user->assignRole('student');
        Student::create([
            'user_id'=>$user->id,
            'student_id'=>$validated['student_id'],
            'class_id'=>$validated['class_id'],
            'phone'=>$validated['phone'],
            'birth_date'=>$validated['birth_date'],
            'address'=>$validated['address'],
            'guardian_name'=>$validated['guardian_name'],
            'guardian_phone'=>$validated['guardian_phone'],
        ]);
        return redirect()->route('students.index')->with('success','Student Added Successfuly');

    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Student $student)
    {
        $student->load('user','classroom');
        return view('Student.show',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classroom = Classes::select('id','class_name','section')->orderBy('section')->get();
        $student = Student::with(['user',])->findOrFail($id);
        return view('Student.edit',compact('student','classroom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_id = $request->user_id;
         $validated = $request->validate([
        //user table
        'name' => 'required|string|max:255',

        // Student table
        'class_id' => 'required|exists:classes,id',
        'phone' => 'required|nullable|string|max:20',
        'birth_date'=>'required|date',
        'address' => 'required|nullable|string|max:500',
        'guardian_name' => 'required|nullable|string|max:255',
        'guardian_phone' => 'required|nullable|string|max:255',
        ]);
        $user = User::findorfail($user_id)->update([
            'name'=>$validated['name'],
        ]);
        Student::findorfail($id)->update([
            'class_id'=>$validated['class_id'],
            'phone'=>$validated['phone'],
            'birth_date'=>$validated['birth_date'],
            'address'=>$validated['address'],
            'guardian_name'=>$validated['guardian_name'],
            'guardian_phone'=>$validated['guardian_phone'],
        ]);
        return redirect()->route('students.index')->with('success','Student Updated Successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findorfail($id)->delete();
        return back()->with('danger','Student Delete It!');
    }
}
