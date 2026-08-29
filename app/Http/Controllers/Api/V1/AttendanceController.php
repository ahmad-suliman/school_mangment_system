<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Class_subject_teacher;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Attendance::class);

        $user = auth()->user();
        $search = $request->search;

        if ($user->hasRole('student')) {
            $attendances = Attendance::with('subject')
                ->where('student_id', $user->student->id)
                ->when($search, function ($query) use ($search) {
                    $query->where('status', 'like', "%{$search}%")
                        ->orWhereHas('subject', fn($q) => $q->where('subject_name', 'like', "%{$search}%"));
                })
                ->latest()
                ->paginate(10);
        } elseif ($user->hasRole('teacher')) {
            $attendances = Attendance::with('student.user', 'subject')
                ->where('teacher_id', $user->teacher->id)
                ->when($search, function ($query) use ($search) {
                    $query->where('status', 'like', "%{$search}%")
                        ->orWhereHas('student.user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('subject', fn($q) => $q->where('subject_name', 'like', "%{$search}%"));
                })
                ->latest()
                ->paginate(10);
        } else {
            $attendances = Attendance::with(['student.user', 'teacher.user', 'subject'])
                ->when($search, function ($query) use ($search) {
                    $query->where('status', 'like', "%{$search}%")
                        ->orWhereHas('student.user', fn($q) => $q->where('name', 'like', "%{$search}%"));
                })
                ->latest()
                ->paginate(10);
        }

        return AttendanceResource::collection($attendances);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {
        $this->authorize('create', Attendance::class); // only teachers pass this now

        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return response()->json(['message' => 'Teacher profile not found'], 404);
        }

        $teacher_id = $teacher->id;

        $allowed = Class_subject_teacher::where([
            'teacher_id' => $teacher_id,
            'subject_id' => $request->subject_id,
            'class_id'   => $request->class_id,
        ])->exists();

        if (!$allowed) {
            return response()->json(['message' => 'Not allowed for this class/subject'], 403);
        }

        $exists = Attendance::where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->where('date', $request->date)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Attendance already taken for this date'], 422);
        }

        $createdAttendances = DB::transaction(function () use ($request, $teacher_id) {
            $created = [];

            foreach ($request->attendance as $student_id => $status) {
                $attendance = Attendance::create([
                    'student_id' => $student_id,
                    'class_id'   => $request->class_id,
                    'subject_id' => $request->subject_id,
                    'teacher_id' => $teacher_id,
                    'date'       => $request->date,
                    'status'     => $status,
                ]);

                $created[] = $attendance;
            }

            return $created;
        });

        return response()->json([
            'message' => 'Attendance saved successfully',
            'count'   => count($createdAttendances),
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance = Attendance::findOrFail($id);
        $this->authorize('update', $attendance);

        $attendance->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Attendance updated successfully',
            'data'    => new AttendanceResource($attendance),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $this->authorize('delete', $attendance);

        $attendance->delete();

        return response()->json(['message' => 'Attendance deleted successfully']);
    }
}
