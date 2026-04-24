@extends('layouts.master')
@section('title', 'Assign Subject to Class')

@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-diagram-project text-primary me-2"></i>
                    Assign Subject to Class
                </h2>
                <p class="text-muted mb-0">
                    Assign a subject and teacher to a specific class.
                </p>
            </div>

            <a href="{{ route('admin.class-subject-teachers.index') }}" class="btn btn-outline-secondary rounded-3">
                <i class="fas fa-arrow-left me-1"></i> Grades
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i> Edit Assignment
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        {{-- Success --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                                <i class="fas fa-circle-check me-2"></i>
                                {{ session('success') }}

                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Error --}}
                        @if (session('danger'))
                            <div class="alert alert-danger rounded-3">
                                {{ session('danger') }}
                            </div>
                        @endif

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3">
                                <strong>Whoops!</strong> Please fix the errors below:
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form action="{{route('admin.class-subject-teachers.update',$classSubjectTeacher->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">

                                {{-- Class --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-school text-primary me-1"></i> Class
                                    </label>
                                    <select name="class_id"
                                        class="form-select rounded-3 @error('class_id') is-invalid @enderror" required>
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ $classSubjectTeacher->class_id == $class->id ? 'selected' : '' }}>
                                                {{ $class->class_name }} - Section {{ $class->section }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Subject --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-book text-success me-1"></i> Subject
                                    </label>
                                    <select name="subject_id"
                                        class="form-select rounded-3 @error('subject_id') is-invalid @enderror" required>
                                        <option value="">Select Subject</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ $classSubjectTeacher->subject_id == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->subject_name }} ({{ $subject->subject_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Teacher --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-user-tie text-info me-1"></i> Teacher
                                    </label>
                                    <select name="teacher_id"
                                        class="form-select rounded-3 @error('teacher_id') is-invalid @enderror" required>
                                        <option value="">Select Teacher</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}"
                                                {{ $classSubjectTeacher->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->user->name ?? 'N/A' }} - {{ $teacher->teacher_id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- Academic Year --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt text-warning me-1"></i> Academic Year
                                    </label>

                                    <select name="academic_year"
                                        class="form-select rounded-3 @error('academic_year') is-invalid @enderror" required>

                                        <option value="">Select Academic Year</option>

                                        @for ($year = date('Y'); $year <= date('Y') + 5; $year++)
                                            <option value="{{ $year }}-{{ $year + 1 }}"
                                                {{ $classSubjectTeacher->academic_year == $year . '-' . ($year + 1) ? 'selected' : '' }}>
                                                {{ $year }} - {{ $year + 1 }}
                                            </option>
                                        @endfor

                                    </select>

                                    @error('academic_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('admin.grades.index')}}" class="btn btn-light border rounded-3">
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-primary rounded-3 fw-semibold">
                                    <i class="fas fa-save me-1"></i> Edit Assignment
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
