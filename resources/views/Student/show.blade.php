@extends('layouts.master')
@section('title', 'Show Student')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-user-graduate text-primary me-2"></i>
                Student Profile
            </h2>
            <p class="text-muted mb-0">View complete student information and account details.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary rounded-3">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>

            <a href="{{ route('students.edit', $student) }}" class="btn btn-primary rounded-3">
                <i class="fas fa-pen-to-square me-1"></i> Edit
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Left Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- Top Banner --}}
                <div class="bg-primary" style="height: 100px;"></div>

                <div class="card-body text-center p-4 mt-n5">

                    {{-- Profile Photo --}}
                    @if($student->user && $student->user->profile_photo)
                        <img src="{{ asset('storage/' . $student->user->profile_photo) }}"
                             alt="Student Photo"
                             class="rounded-circle border border-4 border-white shadow-sm mb-3"
                             width="130"
                             height="130"
                             style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light border border-4 border-white shadow-sm d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 130px; height: 130px;">
                            <i class="fas fa-user text-secondary" style="font-size: 55px;"></i>
                        </div>
                    @endif

                    {{-- Name --}}
                    <h4 class="fw-bold mb-1">{{ $student->user->name ?? 'N/A' }}</h4>

                    {{-- Email --}}
                    <p class="text-muted mb-3">
                        <i class="fas fa-envelope me-1"></i>
                        {{ $student->user->email ?? 'N/A' }}
                    </p>

                    {{-- Student ID --}}
                    <div class="mb-3">
                        <span class="badge bg-primary px-3 py-2 fs-6">
                            <i class="fas fa-id-card me-1"></i> {{ $student->student_id }}
                        </span>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        @if($student->user && $student->user->status == true)
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-circle-check me-1"></i> Active
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-2">
                                <i class="fas fa-circle-xmark me-1"></i> Inactive
                            </span>
                        @endif
                    </div>

                    {{-- Role --}}
                    <div class="mb-4">
                        <span class="badge bg-info text-dark px-3 py-2">
                            <i class="fas fa-user-graduate me-1"></i> {{ $student->user->getRoleNames()->first() ?? 'N/A' }}
                        </span>
                    </div>

                    {{-- Quick Info --}}
                    <div class="text-start border-top pt-3">
                        <div class="mb-2">
                            <small class="text-muted d-block">Class</small>
                            <strong>
                                {{ $student->classroom ? $student->classroom->class_name . ' - Section ' . $student->classroom->section : 'N/A' }}
                            </strong>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted d-block">Phone</small>
                            <strong>{{ $student->phone ?? 'N/A' }}</strong>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted d-block">Birth Date</small>
                            <strong>
                                {{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d M Y') : 'N/A' }}
                            </strong>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-primary rounded-3">
                            <i class="fas fa-pen-to-square me-1"></i> Edit Student
                        </a>

                        <form action="{{ route('students.destroy', $student) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this student?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-outline-danger rounded-3 w-100">
                                <i class="fas fa-trash me-1"></i> Delete Student
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- Right Content --}}
        <div class="col-lg-8">

            {{-- Account Information --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-primary text-white rounded-top-4 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user-shield me-2"></i> Account Information
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-user me-1 text-primary"></i> Full Name
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->user->name ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-envelope me-1 text-primary"></i> Email Address
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->user->email ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-toggle-on me-1 text-success"></i> Status
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ ucfirst($student->user->status ?? 'N/A') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-user-tag me-1 text-danger"></i> Role
                            </label>
                            <div class="form-control bg-light rounded-3">
                                Student
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Student Information --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-info text-white rounded-top-4 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user-graduate me-2"></i> Student Information
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-id-badge me-1 text-info"></i> Student ID
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->student_id }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-school me-1 text-info"></i> Class
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->classroom ? $student->classroom->class_name . ' - Section ' . $student->classroom->section : 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-phone me-1 text-info"></i> Phone Number
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->phone ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-cake-candles me-1 text-info"></i> Birth Date
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d M Y') : 'N/A' }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-location-dot me-1 text-info"></i> Address
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->address ?? 'N/A' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Guardian Information --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-secondary text-white rounded-top-4 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-people-roof me-2"></i> Guardian Information
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-user-group me-1 text-secondary"></i> Guardian Name
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->guardian_name ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-phone-volume me-1 text-secondary"></i> Guardian Phone
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->guardian_phone ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-calendar-plus me-1 text-secondary"></i> Created At
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->created_at ? $student->created_at->format('d M Y, h:i A') : 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-clock-rotate-left me-1 text-secondary"></i> Last Updated
                            </label>
                            <div class="form-control bg-light rounded-3">
                                {{ $student->updated_at ? $student->updated_at->format('d M Y, h:i A') : 'N/A' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
