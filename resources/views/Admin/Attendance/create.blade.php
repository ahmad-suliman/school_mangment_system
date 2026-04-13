@extends('layouts.master')
@section('title','Take Attendance')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="fas fa-calendar-check text-primary me-2"></i>
            Take Attendance
        </h3>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('danger') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- STEP 1: LOAD STUDENTS --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Select Class & Date
        </div>

        <div class="card-body">
            <form action="{{ route('attendance.load') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- CLASS --}}
                    <div class="col-md-4">
                        <label class="form-label">Class</label>
                        <select name="class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ old('class_id', $class_id ?? '') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }} - {{ $class->section }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- DATE --}}
                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date"
                               name="date"
                               value="{{ old('date', $date ?? date('Y-m-d')) }}"
                               class="form-control"
                               required>
                    </div>

                    {{-- BUTTON --}}
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Load Students
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- STEP 2: SHOW STUDENTS --}}
    @isset($students)
    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf

        <input type="hidden" name="class_id" value="{{ $class_id }}">
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="card shadow-sm">

            <div class="card-header bg-success text-white">
                Mark Attendance
            </div>

            <div class="card-body">

                <div class="row g-3 mb-3">

                    {{-- SUBJECT --}}
                    <div class="col-md-6">
                        <label class="form-label">Subject</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">Select Subject</option>

                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">
                                    {{ $subject->subject_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- TEACHER (ADMIN ONLY) --}}
                    @if(auth()->user()->hasRole('admin'))
                    <div class="col-md-6">
                        <label class="form-label">Teacher</label>
                        <select name="teacher_id" class="form-select" required>
                            <option value="">Select Teacher</option>

                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->user->name ?? 'N/A' }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    @endif

                </div>

                {{-- STUDENT TABLE --}}
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $student->user->name ?? 'N/A' }}
                                </td>

                                <td>
                                    <select name="attendance[{{ $student->id }}]" class="form-select">
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                        <option value="late">Late</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                {{-- SUBMIT --}}
                <button type="submit" class="btn btn-success mt-3">
                    <i class="fas fa-save me-1"></i> Save Attendance
                </button>

            </div>
        </div>
    </form>
    @endisset

</div>
@endsection
