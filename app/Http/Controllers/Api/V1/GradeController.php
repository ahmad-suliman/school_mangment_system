<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Resources\GradeResource;
use App\Models\Class_subject_teacher;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Grade::class);
        $search = $request->search;

        if (auth()->user()->hasRole('student')) {
            $student = auth()->user()->student;

            $grades = Grade::with('subject')
                ->where('student_id', $student->id)
                ->when($search, function ($query) use ($search) {
                    $query->where('marks', 'like', "%$search%")
                        ->orWhereHas('subject', fn($q) => $q->where('subject_code', 'like', "%$search%"));
                })
                ->latest()
                ->paginate(10);
        } elseif (auth()->user()->hasRole('teacher')) {
            $teacher = auth()->user()->teacher;

            $grades = Grade::with('student.user', 'subject')
                ->where('teacher_id', $teacher->id)
                ->when($search, function ($query) use ($search) {
                    $query->where('marks', 'like', "%$search%")
                        ->orWhereHas('subject', fn($q) => $q->where('subject_code', 'like', "%$search%"))
                        ->orWhereHas('student.user', fn($q) => $q->where('name', 'like', "%$search%"));
                })
                ->latest()
                ->paginate(10);
        } else {
            // admin
            $grades = Grade::with('student.user', 'subject', 'teacher.user')
                ->when($search, function ($query) use ($search) {
                    $query->where('marks', 'like', "%$search%")
                        ->orWhereHas('subject', fn($q) => $q->where('subject_code', 'like', "%$search%"))
                        ->orWhereHas('teacher.user', fn($q) => $q->where('name', 'like', "%$search%"))
                        ->orWhereHas('student.user', fn($q) => $q->where('name', 'like', "%$search%"));
                })
                ->latest()
                ->paginate(10);
        }

        return GradeResource::collection($grades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
       $this->authorize('create', Grade::class);

        if (auth()->user()->hasRole('teacher')) {
            $teacher = auth()->user()->teacher;

            if (!$teacher) {
                return response()->json(['message' => 'Teacher not found'], 404);
            }

            $teacher_id = $teacher->id;

            $allowed = Class_subject_teacher::where([
                'teacher_id' => $teacher_id,
                'subject_id' => $request->subject_id,
            ])->exists();

            if (!$allowed) {
                return response()->json(['message' => 'Not allowed for this subject'], 403);
            }
        } else {
            $teacher_id = $request->teacher_id;
        }

        $exists = Grade::where([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
        ])->exists();

        if ($exists) {
            return response()->json(['message' => 'Grade already exists for this student & subject'], 422);
        }

        $grade = Grade::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $teacher_id,
            'marks'      => $request->marks,
        ]);

        $student = Student::find($request->student_id);
        $grade->load(['student.user', 'subject', 'teacher.user']);

        return response()->json([
            'message' => 'Grade added successfully',
            'data'    => new GradeResource($grade),
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'marks' => 'required|numeric|min:0|max:100',
        ]);

        $grade = Grade::findOrFail($id);
        $this->authorize('update', $grade);

        $grade->update([
            'marks' => $request->marks,
        ]);

        $grade->load(['student.user', 'subject', 'teacher.user']);

        return response()->json([
            'message' => 'Grade updated successfully',
            'data'    => new GradeResource($grade),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grade = Grade::findOrFail($id);
        $this->authorize('delete', $grade);

        $grade->delete();

        return response()->json(['message' => 'Grade deleted successfully']);
    }
}
