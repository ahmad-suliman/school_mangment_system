@extends('layouts.master')
@section('title', 'show Teacher')
@section('content')
    <div class="container py-5">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                    Teacher Profile
                </h2>
                <p class="text-muted mb-0">View complete teacher information.</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-primary">
                    <i class="fas fa-pen-to-square me-1"></i> Edit
                </a>
            </div>
        </div>

        <div class="row g-4">

            {{-- Left Side --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center p-4">

                        {{-- Profile Image --}}
                        @if ($teacher->profile_image)
                            <img src="{{ asset('storage/' . $teacher->profile_image) }}" alt="Teacher Photo"
                                class="rounded-circle border shadow-sm mb-3" width="140" height="140"
                                style="object-fit: cover;">
                        @elseif($teacher->user && $teacher->user->profile_photo)
                            <img src="{{ asset('storage/' . $teacher->user->profile_photo) }}" alt="Teacher Photo"
                                class="rounded-circle border shadow-sm mb-3" width="140" height="140"
                                style="object-fit: cover;">
                        @else
                            <div class="bg-light border rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 140px; height: 140px;">
                                <i class="fas fa-user text-secondary" style="font-size: 60px;"></i>
                            </div>
                        @endif

                        {{-- Name --}}
                        <h4 class="fw-bold mb-1">{{ $teacher->user->name ?? 'N/A' }}</h4>

                        {{-- Email --}}
                        <p class="text-muted mb-3">
                            <i class="fas fa-envelope me-1"></i>{{ $teacher->user->email ?? 'N/A' }}
                        </p>

                        {{-- Status --}}
                        <div class="mb-3">
                            @if (($teacher->status ?? null) == 'active' || ($teacher->user && $teacher->user->status == 'active'))
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
                        <span class="badge bg-primary px-3 py-2">
                            <i class="fas fa-chalkboard-teacher me-1"></i>
                            {{ $teacher->user->getRoleNames()->first() ?? 'N/A' }}
                        </span>

                        {{-- Action Buttons --}}
                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-primary rounded-3">
                                <i class="fas fa-pen-to-square me-1"></i> Edit Teacher
                            </a>

                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this teacher?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger rounded-3 w-100">
                                    <i class="fas fa-trash me-1"></i> Delete Teacher
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side --}}
            <div class="col-lg-8">

                {{-- Account Info --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-primary text-white rounded-top-4 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-id-card me-2"></i>Account Information
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-user me-1 text-primary"></i> Full Name
                                </label>
                                <div class="form-control bg-light rounded-3">{{ $teacher->user->name ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-envelope me-1 text-primary"></i> Email
                                </label>
                                <div class="form-control bg-light rounded-3">{{ $teacher->user->email ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-toggle-on me-1 text-success"></i> Status
                                </label>
                                <div class="form-control bg-light rounded-3">
                                    {{ ucfirst($teacher->status ?? ($teacher->user->status ?? 'N/A')) }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-user-shield me-1 text-danger"></i> Role
                                </label>
                                <div class="form-control bg-light rounded-3">
                                    {{ $teacher->user->getRoleNames()->first() ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Teacher Info --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-info text-white rounded-top-4 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Information
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-id-badge me-1 text-info"></i> Teacher ID
                                </label>
                                <div class="form-control bg-light rounded-3">{{ $teacher->teacher_id }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-phone me-1 text-info"></i> Phone
                                </label>
                                <div class="form-control bg-light rounded-3">{{ $teacher->phone ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-book-open me-1 text-info"></i> Specialization
                                </label>
                                <div class="form-control bg-light rounded-3">{{ $teacher->specialization ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-calendar-alt me-1 text-info"></i> Hire Date
                                </label>
                                <div class="form-control bg-light rounded-3">
                                    {{ $teacher->hire_date ? \Carbon\Carbon::parse($teacher->hire_date)->format('d M Y') : 'N/A' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-location-dot me-1 text-info"></i> Address
                                </label>
                                <div class="form-control bg-light rounded-3">{{ $teacher->address ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-calendar-plus me-1 text-secondary"></i> Created At
                                </label>
                                <div class="form-control bg-light rounded-3">
                                    {{ $teacher->created_at ? $teacher->created_at->format('d M Y, h:i A') : 'N/A' }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
