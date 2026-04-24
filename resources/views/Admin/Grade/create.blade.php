@extends('layouts.master')
@section('title','Add Grade')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fa-solid fa-pen-to-square text-primary me-2"></i>
                Add New Grade
            </h3>
            <p class="text-muted mb-0">Assign marks to students easily.</p>
        </div>

        <a href="{{ auth()->user()->hasRole('admin') ? route('admin.grades.index') : route('teacher.grades.index')}}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- ALERTS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Fix these errors:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <i class="fas fa-plus-circle me-2"></i> Grade Details
        </div>

        <div class="card-body p-4">
            <form action="{{ auth()->user()->hasRole('admin')?route('admin.grades.store') : route('teacher.grades.store')}}" method="POST">
                @csrf

                <div class="row g-4">

                    {{-- STUDENT --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-user-graduate text-primary me-1"></i> Student
                        </label>
                        <select name="student_id" class="form-select">
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SUBJECT --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-book text-success me-1"></i> Subject
                        </label>
                        <select name="subject_id" class="form-select">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">
                                    {{ $subject->subject_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @role('admin')
                    {{-- TEACHER --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-chalkboard-teacher text-warning me-1"></i> Teacher
                        </label>
                        <select name="teacher_id" class="form-select">
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endrole
                    {{-- MARKS --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-percent text-danger me-1"></i> Marks
                        </label>
                        <input type="number"
                               name="marks"
                               class="form-control"
                               placeholder="Enter marks (0 - 100)"
                               min="0"
                               max="100"
                               value="{{ old('marks') }}">
                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="mt-4 d-flex justify-content-end gap-2">

                    <a href="{{ auth()->user()->hasRole('admin') ? route('admin.grades.index') : route('teacher.grades.index')}}" class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save Grade
                    </button>

                </div>

            </form>
        </div>
    </div>

</div>
@endsection
