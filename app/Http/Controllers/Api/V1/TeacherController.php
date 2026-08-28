<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Mail\WelcomeMail;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TeacherController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Teacher::class);
        $search = $request->search;
        $teachers = Teacher::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('specialization', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            })
            ->latest()
            ->paginate(10);
        return TeacherResource::collection($teachers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        $this->authorize('create', Teacher::class);
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
        Mail::to($user->email)->queue(new WelcomeMail($user));
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'teacher_id' => $data['teacher_id'],
            'phone' => $data['phone'] ?? null,
            'specialization' => $data['specialization'],
            'hire_date' => $data['hire_date'],
            'address' => $data['address'],
        ]);
        $teacher->load('user');
        return response()->json([
            'message' => 'teacher created successfully',
            'data' => new TeacherResource($teacher),
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $this->authorize('view', $teacher);
        $teacher->load('user');
        return response()->json([
            'teacher' => new TeacherResource($teacher),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, string $id)
    {
        $teacher = Teacher::findorfail($id);
        $this->authorize('update', $teacher);
        $data = $request->validated();
        $teacher->user()->update([
                'name' => $data['name'],
            ]);
        $teacher->update([
            'phone' => $data['phone'],
            'specialization' => $data['specialization'],
            'hire_date' => $data['hire_date'],
            'address' => $data['address'],
        ]);
        $teacher->load(['user']);
        return response()->json([
            'message'=>'teacher updated successfully',
            'data'=>new TeacherResource($teacher),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::with('user')->findorfail($id);
        $this->authorize('delete',$teacher);
        $user = $teacher->user;
        $teacher->delete();
        if($user){
            $user->delete();
        }
        return response()->json([
                'message' => 'Teacher deleted successfully',
            ]);;
    }
}
