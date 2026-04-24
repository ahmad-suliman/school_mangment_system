@extends('layouts.master')
@section('title', 'Add Subject')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-book-open text-primary me-2"></i>
                Add New Subject
            </h2>
            <p class="text-muted mb-0">Create a new subject for your school management system.</p>
        </div>

        <a href="{{route('admin.subjects.index')}}" class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-1"></i> Subjects
        </a>
    </div>
       @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <i class="fas fa-circle-check me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i> Subject Information
                    </h5>
                </div>

                <div class="card-body p-4">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            <i class="fas fa-circle-exclamation me-2"></i>
                            Please fix the following errors:
                            <ul class="mb-0 mt-2 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{route('admin.subjects.store')}}" method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- Subject Name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-book me-1 text-primary"></i> Subject Name
                                </label>
                                <input type="text"
                                       name="subject_name"
                                       class="form-control rounded-3 @error('subject_name') is-invalid @enderror"
                                       placeholder="Enter subject name (e.g. Mathematics)"
                                       value="{{ old('subject_name') }}">
                                @error('subject_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Subject Code --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-code me-1 text-primary"></i> Subject Code
                                </label>
                                <input type="text"
                                       name="subject_code"
                                       class="form-control rounded-3 @error('subject_code') is-invalid @enderror"
                                       placeholder="Enter subject code (e.g. MATH)"
                                       value="{{ old('subject_code') }}">
                                @error('subject_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Example: MATH, ENG, PHY, CHEM
                                </small>
                            </div>

                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{route('admin.subjects.index')}}" class="btn btn-light border rounded-3">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>

                            <button type="submit" class="btn btn-primary rounded-3">
                                <i class="fas fa-save me-1"></i> Save Subject
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
