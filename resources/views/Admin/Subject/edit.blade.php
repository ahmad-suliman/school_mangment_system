@extends('layouts.master')
@section('title', 'Edit Subject')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-pen-to-square text-primary me-2"></i>
                Edit Subject
            </h2>
            <p class="text-muted mb-0">Update subject information in your school management system.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary rounded-3">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>

            <a href="#" class="btn btn-outline-primary rounded-3">
                <i class="fas fa-eye me-1"></i> View Subject
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-light rounded-top-4 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-book-open me-2"></i> Subject Information
                    </h5>
                </div>

                <div class="card-body p-4">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
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

                    {{-- Form --}}
                    <form action="{{route('subjects.update',$subject)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            {{-- Subject Name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-book me-1 text-primary"></i> Subject Name
                                </label>
                                <input type="text"
                                       name="subject_name"
                                       class="form-control rounded-3 @error('subject_name') is-invalid @enderror"
                                       placeholder="Enter subject name"
                                       value="{{  $subject->subject_name }}">
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
                                       placeholder="Enter subject code"
                                       value="{{ $subject->subject_code }}">
                                @error('subject_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Example: MATH, ENG, SCI, PHY, CHEM
                                </small>
                            </div>

                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex flex-column flex-md-row justify-content-end gap-2 mt-4">
                            <a href="{{ route('subjects.index') }}" class="btn btn-light border rounded-3">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>

                            <button type="submit" class="btn btn-primary text-light rounded-3 fw-semibold">
                                <i class="fas fa-save me-1"></i> Update Subject
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
