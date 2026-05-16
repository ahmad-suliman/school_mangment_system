<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\Class_subject_teacher;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use App\Notifications\AttendanceAddedNotification;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttendanceController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Attendance::class);

        $user = auth()->user();

        if ($user->hasRole('student')) {

            $attendances = Attendance::with('subject')
                ->where('student_id', $user->student->id)
                ->latest()
                ->paginate(10);
        } elseif ($user->hasRole('teacher')) {

            $attendances = Attendance::with('student.user', 'subject')
                ->where('teacher_id', $user->teacher->id)
                ->latest()
                ->paginate(10);
        } else {

            $attendances = Attendance::with(
                'student.user',
                'teacher.user',
                'subject'
            )
                ->latest()
                ->paginate(10);
        }

        return view('Admin.Attendance.index', compact('attendances'));
    }
    public function create()
    {
        $this->authorize('create',Attendance::class);
        $classes = Classes::all();
        if (auth()->user()->hasRole('admin')) {
            $teachers = Teacher::all();
            return view('Admin.Attendance.create', compact('classes', 'teachers'));
        }

        return view('Admin.Attendance.create', compact('classes'));
    }

    public function loadStudents(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
        ]);

        $classes = Classes::all();

        $students = Student::with('user')
            ->where('class_id', $request->class_id)
            ->get();

        // TEACHER
        if (auth()->user()->hasRole('teacher')) {

            $teacher = auth()->user()->teacher;

            if (!$teacher) {
                abort(403, 'Teacher not found');
            }

            $subjects = Class_subject_teacher::where('teacher_id', $teacher->id)
                ->where('class_id', $request->class_id)
                ->with('subject')
                ->get()
                ->pluck('subject');

            return view('Admin.Attendance.create', [
                'classes' => $classes,
                'students' => $students,
                'subjects' => $subjects,
                'class_id' => $request->class_id,
                'date' => $request->date,
            ]);
        }

        //  ADMIN
        return view('Admin.Attendance.create', [
            'classes' => $classes,
            'students' => $students,
            'subjects' => Subject::all(),
            'teachers' => Teacher::with('user')->get(),
            'class_id' => $request->class_id,
            'date' => $request->date,
        ]);
    }

    public function store(StoreAttendanceRequest $request)
    {
        $this->authorize('create',Attendance::class);
        //  Get teacher_id
        if (auth()->user()->hasRole('teacher')) {

            $teacher = auth()->user()->teacher;

            if (!$teacher) {
                return redirect()->back()->with('danger', 'Teacher profile not found.');
            }

            $teacher_id = $teacher->id;
        } else {
            $teacher_id = $request->teacher_id;
        }

        //  Check permission (teacher only)
        if (auth()->user()->hasRole('teacher')) {

            $allowed = Class_subject_teacher::where([
                'teacher_id' => $teacher_id,
                'subject_id' => $request->subject_id,
                'class_id' => $request->class_id,
            ])->exists();

            if (!$allowed) {
                return redirect()->back()->with('danger', 'Not allowed.');
            }
        }

        // Prevent duplicate
        $exists = Attendance::where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->where('date', $request->date)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()
                ->with('danger', 'Attendance already taken.');
        }

        // Save
        foreach ($request->attendance as $student_id => $status) {

           $attendance =  Attendance::create([
                'student_id' => $student_id,
                'class_id'   => $request->class_id,
                'subject_id' => $request->subject_id,
                'teacher_id' => $teacher_id,
                'date'       => $request->date,
                'status'     => $status,
            ]);

            $student = Student::find($student_id);

            if ($student && $student->user) {

                $student->user->notify(
                    new AttendanceAddedNotification($attendance)
                );
        }
        }
        return redirect()->route('teacher.attendance.index')->with('success', 'Attendance saved');

    }
    public function edit($id)
    {
        $attendance = Attendance::with('student.user')->findOrFail($id);
        $this->authorize('update',$attendance);
        return view('Admin.Attendance.edit', compact('attendance'));
    }

    public function update(Request $request,string $id)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance = Attendance::findOrFail($id);
        $this->authorize('update',$attendance);
        $attendance->update([
            'status' => $request->status,
        ]);

        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.attendance.index')
                ->with('success', 'Attendance updated successfully');
        } else {
            return redirect()->route('teacher.attendance.index')
                ->with('success', 'Attendance updated successfully');
        }
    }

    public function destroy(string $id)
    {
            $attendance = Attendance::findOrFail($id);
            $this->authorize('delete',$attendance);
            $attendance->delete();
            return back()->with('success', 'Attendance deleted successfully');

    }
}
