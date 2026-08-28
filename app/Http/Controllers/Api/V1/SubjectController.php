<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $this->authorize('viewAny', Subject::class);
        $search = $request->search;
        //if user student he see just his subject
        if (auth()->user()->hasRole('student')) {
            $student = auth()->user()->student;
            $subjects = Subject::query()
                ->whereHas('classSubjectTeachers', function ($q) use ($student) {
                    $q->where('class_id', $student->class_id);
                })
                ->when($search, function ($query) use ($search) {
                    $query->where('subject_name', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(10);
        } else {
            //else user admin can see all subjects
            $subjects = Subject::query()
            ->when($search,function ($query) use ($search){
                $query->where('subject_name','like',"%$search%");
            })
            ->paginate(10);
        }

        return SubjectResource::collection($subjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $this->authorize('create', Subject::class);
        $data = $request->validated();
        $subject = Subject::create([
            'subject_name' => $data['subject_name'],
            'subject_code' => strtoupper($data['subject_code']),
        ]);
        return response()->json([
            'message' => 'Subject Created Successfully!',
            'data'=> new SubjectResource($subject),
        ],201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSubjectRequest $request, Subject $subject)
    {
        $this->authorize('update', $subject);
            $data = $request->validated();
            $subject->update([
                'subject_name' => $data['subject_name'],
                'subject_code' => strtoupper($data['subject_code']),
            ]);

            return response()->json([
                'message' =>'Subject Updated!',
                'data' =>new SubjectResource($subject),
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findorfail($id);
        $this->authorize('delete', $subject);
        $subject->delete();
        return response()->json([
            'message'=>'Subject Deleted!',
        ]);
    }
}
