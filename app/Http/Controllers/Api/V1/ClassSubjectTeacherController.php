<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassSubjectTeacherRequest;
use App\Http\Resources\ClassSubjectTeacherResource;
use App\Models\Class_subject_teacher;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ClassSubjectTeacherController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Class_subject_teacher::class);
        $search = $request->search;
        $assignments = Class_subject_teacher::with([
            'classroom',
            'subject',
            'teacher.user',
        ])->when($search,function ($query) use ($search){
            $query->orWhereHas('classroom',function ($q) use ($search){
                $q->where('class_name','like',"%$search%");
            })
            ->orWhereHas('subject',function ($q) use ($search){
                  $q->where('subject_code','like',"%$search%");
            })
            ->orWhereHas('teacher.user',function ($q) use ($search){
                  $q->where('name','like',"%$search%");
            });
        })
        ->latest()
        ->paginate(10);

        return ClassSubjectTeacherResource::collection($assignments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassSubjectTeacherRequest $request)
    {
         $this->authorize('create', Class_subject_teacher::class);

        $assignment = Class_subject_teacher::create($request->validated());
        $assignment->load(['classroom', 'subject', 'teacher.user']);

        return response()->json([
            'message' => 'Subject assigned successfully',
            'data'    => new ClassSubjectTeacherResource($assignment),
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassSubjectTeacherRequest $request, string $id)
    {
        $assignment = Class_subject_teacher::findOrFail($id);
        $this->authorize('update', $assignment);

        $assignment->update($request->validated());
        $assignment->load(['classroom', 'subject', 'teacher.user']);

        return response()->json([
            'message' => 'Assignment updated successfully',
            'data'    => new ClassSubjectTeacherResource($assignment),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $assignment = Class_subject_teacher::findOrFail($id);
        $this->authorize('delete', $assignment);

        $assignment->delete();

        return response()->json(['message' => 'Assignment deleted successfully']);
    }
}
