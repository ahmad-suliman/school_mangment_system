@extends('layouts.master')
@section('title','Edit Attendance')

@section('content')
<div class="container py-4">

    <h3 class="fw-bold mb-4">
        <i class="fas fa-edit text-warning me-2"></i>
        Edit Attendance
    </h3>

    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow-sm p-4">

            <div class="mb-3">
                <label class="form-label">Student</label>
                <input type="text" class="form-control"
                       value="{{ $attendance->student->user->name }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Class</label>
                <input type="text" class="form-control"
                       value="{{ $attendance->classroom->class_name }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" class="form-control"
                       value="{{ $attendance->subject->subject_name }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="text" class="form-control"
                       value="{{ $attendance->date }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
                    <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>Late</option>
                </select>
            </div>

            <button class="btn btn-success">
                <i class="fas fa-save"></i> Update
            </button>

        </div>

    </form>

</div>
@endsection
