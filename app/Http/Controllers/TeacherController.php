<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{

    public function index()
    {
        $teachers = Teacher::with('user')->latest()->paginate(10);
        return view('Admin.Teacher.index', compact('teachers'));
    }

    public function create()
    {
        return view('Admin.Teacher.create', ['teacher_id' => Teacher::count()]);
    }


    public function store(StoreTeacherRequest $request)
    {
        $data = $request->validated();
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('teachers', 'public');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => $data['status'],
            'profile_photo' => $photoPath,
        ]);
        $user->assignRole('teacher');
        Teacher::create([
            'user_id' => $user->id,
            'teacher_id' => $data['teacher_id'],
            'phone' => $data['phone'] ?? null,
            'specialization' => $data['specialization'],
            'hire_date' => $data['hire_date'],
            'address' => $data['address'],
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
        return view('Admin.Teacher.edit', compact('teacher'));
    }


    public function update(UpdateTeacherRequest $request, string $id)
    {
        $data = $request->validated();
        $user = User::findorfail($request->u_id)->update([
            'name' => $data['name'],

        ]);
        Teacher::findorfail($id)->update([
            'phone' => $data['phone'],
            'specialization' => $data['specialization'],
            'hire_date' => $data['hire_date'],
            'address' => $data['address'],
        ]);
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher edited successfully.');
    }



    public function destroy(string $id)
    {
        if (auth()->user()->hasRole('admin')) {
            $teacher = User::findorfail($id)->delete();
            return back();
        } else {
            abort(403);
        }
    }
}
