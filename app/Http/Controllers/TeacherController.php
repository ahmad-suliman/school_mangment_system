<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TeacherController extends Controller
{
    use AuthorizesRequests;
    //show all teacher
    public function index(Request $request)
    {
        $this->authorize('viewAny',Teacher::class);
        $search = $request->search;
        $teachers = Teacher::with('user')
        ->when($search , function ($query) use ($search){
            $query->where('specialization','like',"%$search%")
            ->orWhereHas('user',function ($q) use ($search){
                $q->where('name','like',"%$search%");
            });
        })
        ->latest()
        ->paginate(10);
        return view('Admin.Teacher.index', compact('teachers'));
    }
    // create page teacher
    public function create()
    {
        $this->authorize('create',Teacher::class);
        return view('Admin.Teacher.create', ['teacher_id' => Teacher::count()]);
    }

    // save teacher in DB
    public function store(StoreTeacherRequest $request)
    {
        $this->authorize('create',Teacher::class);
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
        Mail::to($user->email)->send(new WelcomeMail($user));
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

    //show teacher info
    public function show(\App\Models\Teacher $teacher)
    {
        $this->authorize('view',$teacher);
        $teacher->load('user');

        return view('Admin.Teacher.show', compact('teacher'));
    }
    // edit teacher
    public function edit(string $id)
    {

        $teacher = Teacher::with('user')->findOrFail($id);
        $this->authorize('update',$teacher);
        return view('Admin.Teacher.edit', compact('teacher'));
    }

    // update teacher
    public function update(UpdateTeacherRequest $request, string $id)
    {
        $teacher = Teacher::findorfail($id);
        $this->authorize('update',$teacher);
        $data = $request->validated();
        $user = User::findorfail($request->u_id)->update([
            'name' => $data['name'],

        ]);
        $teacher->update([
            'phone' => $data['phone'],
            'specialization' => $data['specialization'],
            'hire_date' => $data['hire_date'],
            'address' => $data['address'],
        ]);
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher edited successfully.');
    }

    //delete teacher
    public function destroy(string $id)
    {
        $teacher = User::findorfail($id);
        $this->authorize('delete',$teacher);
        $teacher->delete();
            return back();

    }
}
