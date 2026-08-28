<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Mail\WelcomeMail;
use App\Models\Class_subject_teacher;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Student::class);
        $search = $request->search;
        $user = auth()->user;
        if ($user->hasRole('admin')) {
            $students = Student::with(['user', 'classroom'])
                ->when($search, function ($query) use ($search) {
                    $query->where('address', 'like', "%$search%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('classroom', function ($q) use ($search) {
                            $q->where('class_name', 'like', "%$search%");
                        });
                })
                ->latest()
                ->paginate(10);
        } elseif ($user->hasRole('teacher')) {
            $teacher = $user->teacher;
            $classId = Class_subject_teacher::where('teacher_id', $teacher->id)->pluck('class_id')->unique();
            $students = Student::with(['user', 'classroom'])
                ->when($search, function ($query) use ($search) {
                    $query->where('address', 'like', "%$search%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('classroom', function ($q) use ($search) {
                            $q->where('class_name', 'like', "%$search%");
                        });
                })
                ->whereIn('class_id', $classId)
                ->latest()
                ->paginate(10);
        }
        return StudentResource::collection($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $this->authorize('create', Student::class);

        $data = $request->validated();

        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('students', 'public');
        }

        $user = User::create([
            'name'           => $data['name'],
            'email'          => $data['email'],
            'password'       => Hash::make($data['password']),
            'status'         => $data['status'],
            'profile_photo'  => $photoPath,
        ]);

        $user->assignRole('student');

        Mail::to($user->email)->queue(new WelcomeMail($user));

        $student = Student::create([
            'user_id'        => $user->id,
            'student_id'     => $data['student_id'],
            'class_id'       => $data['class_id'],
            'phone'          => $data['phone'],
            'birth_date'     => $data['birth_date'],
            'address'        => $data['address'],
            'guardian_name'  => $data['guardian_name'],
            'guardian_phone' => $data['guardian_phone'],
        ]);

        $student->load(['user', 'classroom']);

        return response()->json([
            'message' => 'Student added successfully',
            'data'    => new StudentResource($student),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $this->authorize('view', $student);

        $student->load('user', 'classroom');
        $grades = Grade::with(['subject'])->where('student_id', $student->id)->get();

        return response()->json([
            'student' => new StudentResource($student),
            'grades'  => $grades,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        $student = Student::findOrFail($id);
        $this->authorize('update', $student);

        $data = $request->validated();

        $student->user()->update([
            'name' => $data['name'],
        ]);

        $student->update([
            'class_id'       => $data['class_id'],
            'phone'          => $data['phone'],
            'birth_date'     => $data['birth_date'],
            'address'        => $data['address'],
            'guardian_name'  => $data['guardian_name'],
            'guardian_phone' => $data['guardian_phone'],
        ]);

        $student->load(['user', 'classroom']);

        return response()->json([
            'message' => 'Student updated successfully',
            'data'    => new StudentResource($student),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::with('user')->findOrFail($id);
        $this->authorize('delete', $student);
        $user = $student->user;
        $student->delete();
        if ($user) {
            $user->delete();
        }
        return response()->json([
                'message' => 'Student deleted successfully',
            ]);
    }
}
