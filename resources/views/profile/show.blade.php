@extends('layouts.master')
@section('title', 'Profile')
@section('content')
    <div class="container py-5">

        @php
            $role = $user->getRoleNames()->first();
        @endphp

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-user-circle text-primary me-2"></i>
                    My Profile
                </h2>
                <p class="text-muted mb-0">View your account details and role information.</p>
            </div>
            @role('admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            @endrole
            @role('teacher')
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            @endrole
            @role('student')
                <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            @endrole
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="fas fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">

            {{-- LEFT SIDE --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center p-4">

                        {{-- Profile Image --}}
                        @if ($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo"
                                class="rounded-circle border shadow-sm mb-3" width="140" height="140"
                                style="object-fit: cover;">
                        @else
                            <div class="bg-light border rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 140px; height: 140px;">
                                <i class="fas fa-user text-secondary" style="font-size: 60px;"></i>
                            </div>
                        @endif

                        {{-- Name --}}
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>

                        {{-- Email --}}
                        <p class="text-muted mb-3">
                            <i class="fas fa-envelope me-1"></i>{{ $user->email }}
                        </p>

                        {{-- Status Badge --}}
                        <div class="mb-3">
                            @if ($user->status == 1)
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-circle-check me-1"></i> {Active}
                                </span>
                            @else
                                <span class="badge bg-danger px-3 py-2">
                                    <i class="fas fa-circle-xmark me-1"></i> Inactive
                                </span>
                            @endif
                        </div>

                        {{-- Role Badge --}}
                        <div class="mb-3">
                            @if ($role == 'admin')
                                <span class="badge bg-danger px-3 py-2">
                                    <i class="fas fa-user-shield me-1"></i> Admin
                                </span>
                            @elseif($role == 'teacher')
                                <span class="badge bg-primary px-3 py-2">
                                    <i class="fas fa-chalkboard-teacher me-1"></i> Teacher
                                </span>
                            @elseif($role == 'student')
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-user-graduate me-1"></i> Student
                                </span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">
                                    <i class="fas fa-user me-1"></i> User
                                </span>
                            @endif
                        </div>

                        {{-- Buttons --}}
                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary rounded-3">
                                <i class="fas fa-pen-to-square me-1"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-8">

                {{-- Basic User Info --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-primary text-white rounded-top-4 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-id-card me-2"></i>Basic Account Information
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-user me-1 text-primary"></i> Full Name
                                </label>
                                <div class="form-control bg-light rounded-3">{{ $user->name }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-envelope me-1 text-primary"></i> Email
                                </label>
                                <div class="form-control bg-light rounded-3">{{ $user->email }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-toggle-on me-1 text-success"></i> Status
                                </label>
                                <div class="form-control bg-light rounded-3">{{ ucfirst($user->status) }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-user-tag me-1 text-danger"></i> Role
                                </label>
                                <div class="form-control bg-light rounded-3">{{ $role ? ucfirst($role) : 'No Role' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-hashtag me-1 text-dark"></i> User ID
                                </label>
                                <div class="form-control bg-light rounded-3">#{{ $user->id }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="fas fa-calendar-plus me-1 text-info"></i> Created At
                                </label>
                                <div class="form-control bg-light rounded-3">
                                    {{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ADMIN SECTION --}}
                @if ($role == 'admin')
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-danger text-white rounded-top-4 py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-user-shield me-2"></i>Admin Information
                            </h5>
                        </div>

                        <div class="card-body p-4">
                            <div class="row g-3 text-center">
                                <div class="col-md-4">
                                    <div class="border rounded-4 p-3 bg-light">
                                        <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                        <h6 class="fw-bold">System Role</h6>
                                        <p class="mb-0 text-muted">Administrator</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded-4 p-3 bg-light">
                                        <i class="fas fa-lock fa-2x text-danger mb-2"></i>
                                        <h6 class="fw-bold">Access Level</h6>
                                        <p class="mb-0 text-muted">Full Access</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded-4 p-3 bg-light">
                                        <i class="fas fa-gear fa-2x text-dark mb-2"></i>
                                        <h6 class="fw-bold">Permissions</h6>
                                        <p class="mb-0 text-muted">Manage System</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- TEACHER SECTION --}}
                @if ($role == 'teacher' && $user->teacher)
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
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
                                    <div class="form-control bg-light rounded-3">{{ $user->teacher->teacher_id }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-phone me-1 text-info"></i> Phone
                                    </label>
                                    <div class="form-control bg-light rounded-3">{{ $user->teacher->phone ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-book-open me-1 text-info"></i> Specialization
                                    </label>
                                    <div class="form-control bg-light rounded-3">
                                        {{ $user->teacher->specialization ?? 'N/A' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-graduation-cap me-1 text-info"></i> Qualification
                                    </label>
                                    <div class="form-control bg-light rounded-3">
                                        {{ $user->teacher->qualification ?? 'N/A' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-calendar-alt me-1 text-info"></i> Hire Date
                                    </label>
                                    <div class="form-control bg-light rounded-3">
                                        {{ $user->teacher->hire_date ? \Carbon\Carbon::parse($user->teacher->hire_date)->format('d M Y') : 'N/A' }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-location-dot me-1 text-info"></i> Address
                                    </label>
                                    <div class="form-control bg-light rounded-3">{{ $user->teacher->address ?? 'N/A' }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

                {{-- STUDENT SECTION --}}
                @if ($role == 'student' && $user->student)
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-success text-white rounded-top-4 py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-user-graduate me-2"></i>Student Information
                            </h5>
                        </div>

                        <div class="card-body p-4">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-id-card me-1 text-success"></i> Student ID
                                    </label>
                                    <div class="form-control bg-light rounded-3">{{ $user->student->student_id ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-phone me-1 text-success"></i> Phone
                                    </label>
                                    <div class="form-control bg-light rounded-3">{{ $user->student->phone ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-calendar-day me-1 text-success"></i> Date of Birth
                                    </label>
                                    <div class="form-control bg-light rounded-3">
                                        {{ $user->student->birth_date ? \Carbon\Carbon::parse($user->student->birth_date)->format('d M Y') : 'N/A' }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-location-dot me-1 text-success"></i> Address
                                    </label>
                                    <div class="form-control bg-light rounded-3">{{ $user->student->address ?? 'N/A' }}
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-school me-1 text-success"></i> Class
                                    </label>
                                    <div class="form-control bg-light rounded-3">
                                        {{ $user->student->classroom->class_name ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">
                                        <i class="fas fa-school me-1 text-success"></i> Section
                                    </label>
                                    <div class="form-control bg-light rounded-3">
                                        {{ $user->student->classroom->section ?? 'N/A' }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

                {{-- Summary --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-circle-info text-primary me-2"></i>Account Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-md-4">
                                <div class="border rounded-4 p-3 bg-light">
                                    <i class="fas fa-user fa-2x text-primary mb-2"></i>
                                    <h6 class="fw-bold mb-1">Account Type</h6>
                                    <p class="text-muted mb-0">{{ $role ? ucfirst($role) : 'User' }}</p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border rounded-4 p-3 bg-light">
                                    <i class="fas fa-shield-check fa-2x text-success mb-2"></i>
                                    <h6 class="fw-bold mb-1">Status</h6>
                                    <p class="text-muted mb-0">{{ ucfirst($user->status) }}</p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border rounded-4 p-3 bg-light">
                                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                    <h6 class="fw-bold mb-1">Member Since</h6>
                                    <p class="text-muted mb-0">
                                        {{ $user->created_at ? $user->created_at->format('M Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> {{-- END RIGHT --}}
        </div>
    </div>
@endsection
