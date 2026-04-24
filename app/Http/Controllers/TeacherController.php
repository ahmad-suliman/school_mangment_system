<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class TeacherController extends Controller
{

    public function index(){
        $teachers = Teacher::with('user')->latest()->paginate(10);
        return view('Admin.Teacher.index',compact('teachers'));
    }

    public function create(){
        return view('Admin.Teacher.create',['teacher_id'=>Teacher::count()]);
    }


    public function store(Request $request)
    {
          $validated = $request->validate([
        // Users table
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
        'status' => 'required|in:0,1',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        // Teachers table
        'teacher_id' => 'required|string|max:50|unique:teachers,teacher_id',
        'phone' => 'nullable|string|max:20',
        'specialization' => 'nullable|string|max:255',
        'hire_date' => 'nullable|date',
        'address' => 'nullable|string|max:500',
    ]);
     $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('teachers', 'public');
        }

    $user = User::create([
        'name'=>$validated['name'],
        'email'=>$validated['email'],
        'password'=>Hash::make($validated['password']),
        'status'=>$validated['status'],
        'profile_photo'=>$photoPath,
    ]);
    $user->assignRole('teacher');
      Teacher::create([
            'user_id' => $user->id,
            'teacher_id' => $validated['teacher_id'],
            'phone' => $validated['phone'] ?? null,
            'specialization' => $validated['specialization'],
            'hire_date' => $validated['hire_date'] ,
            'address' => $validated['address'] ,
        ]);
          return redirect()->route('admin.teachers.index')->with('success', 'Teacher added successfully.');
    }


   public function show(\App\Models\Teacher $teacher)
    {
        $teacher->load('user');

        return view('Admin.Teacher.show', compact('teacher'));
    }

    public function edit(string $id)
    {

        $teacher = Teacher::with('user')->findOrFail($id);
        return view('Admin.Teacher.edit',compact('teacher'));
    }


    public function update(Request $request, string $id)
    {
             $validated = $request->validate([
        // Users table
        'name' => 'required|string|max:255',

        // Teachers table

        'phone' => 'nullable|string|max:20',
        'specialization' => 'nullable|string|max:255',
        'hire_date' => 'nullable|date',
        'address' => 'nullable|string|max:500',
    ]);

    $user = User::findorfail($request->u_id)->update([
        'name'=>$validated['name'],

    ]);

      Teacher::findorfail($id)->update([
            'phone' => $validated['phone'] ,
            'specialization' => $validated['specialization'],
            'hire_date' => $validated['hire_date'] ,
            'address' => $validated['address'] ,
        ]);
          return redirect()->route('admin.teachers.index')->with('success', 'Teacher edited successfully.');
    }



    public function destroy(string $id)
    {
        if(auth()->user()->hasRole('admin')){
        $teacher = User::findorfail($id)->delete();
        return back();
        }else{
            abort(403);
        }
    }

}
