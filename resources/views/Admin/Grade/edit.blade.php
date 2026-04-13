@extends('layouts.master')
@section('title','Edit Grade')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-pen-to-square text-warning me-2"></i>
                Edit Grade
            </h2>
            <p class="text-muted mb-0">Update student marks.</p>
        </div>

        <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- ALERTS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-warning text-dark rounded-top-4">
            <i class="fas fa-edit me-2"></i> Edit Grade Details
        </div>

        <div class="card-body p-4">

            <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- STUDENT INFO (READ ONLY) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-user-graduate text-primary me-1"></i> Student
                        </label>
                        <div class="form-control bg-light">
                            {{ $grade->student->user->name ?? 'N/A' }}
                        </div>
                    </div>

                    {{-- SUBJECT --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-book text-success me-1"></i> Subject
                        </label>
                        <div class="form-control bg-light">
                            {{ $grade->subject->subject_name ?? 'N/A' }}
                        </div>
                    </div>

                    {{-- TEACHER --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-chalkboard-teacher text-warning me-1"></i> Teacher
                        </label>
                        <div class="form-control bg-light">
                            {{ $grade->teacher->user->name ?? 'N/A' }}
                        </div>
                    </div>

                    {{-- MARKS --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-percent text-danger me-1"></i> Marks
                        </label>

                        <input type="number"
                               name="marks"
                               value="{{ old('marks', $grade->marks) }}"
                               class="form-control"
                               min="0"
                               max="100">

                        {{-- LIVE STATUS --}}
                        <small class="text-muted">
                            Status:
                            <span class="fw-bold {{ $grade->marks >= 50 ? 'text-success' : 'text-danger' }}">
                                {{ $grade->marks >= 50 ? 'Pass' : 'Fail' }}
                            </span>
                        </small>
                    </div>

                </div>

                {{-- ACTION BUTTONS --}}
                <div class="mt-4 d-flex justify-content-end gap-2">

                    <a href="{{ route('grades.index') }}" class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="fas fa-save me-1"></i> Update Grade
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection
