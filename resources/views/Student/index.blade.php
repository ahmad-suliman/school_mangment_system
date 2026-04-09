@extends('layouts.master')

@section('title', 'Students')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fa-solid fa-user-graduate text-primary me-2"></i>
                Student Management
            </h2>
            <p class="text-muted mb-0">View, manage, and organize all students in the system.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
        <a href="{{ route('students.create') }}" class="btn btn-primary rounded-3 px-4">
            <i class="fa-solid fa-user-plus me-2"></i> Add New Student
        </a>
        </div>

    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="fas fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Error Message --}}
    @if (session('danger'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="fas fa-triangle-exclamation me-2"></i>
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        {{-- Card Header --}}
        <div class="card-header bg-white border-0 py-3 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-users text-primary me-2"></i> Student List
                </h5>

                <div class="w-100" style="max-width: 320px;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 rounded-start-3">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-0 rounded-end-3" placeholder="Search students...">
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Body --}}
        <div class="card-body p-0">

            @if ($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3 text-muted small">#</th>
                                <th class="py-3 text-muted small">Student</th>
                                <th class="py-3 text-muted small">Student ID</th>
                                <th class="py-3 text-muted small">Class</th>
                                <th class="py-3 text-muted small">Phone</th>
                                <th class="py-3 text-muted small">Birth Date</th>
                                <th class="py-3 text-muted small">Address</th>
                                <th class="py-3 text-muted small">Guardian</th>
                                <th class="py-3 text-muted small">Status</th>
                                <th class="py-3 text-center text-muted small">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    {{-- Row Number --}}
                                    <td class="px-4 fw-semibold text-muted">
                                        {{ $students->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Student Info --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($student->user && $student->user->profile_photo)
                                                <img src="{{ asset('storage/' . $student->user->profile_photo) }}"
                                                     alt="Student Photo"
                                                     class="rounded-circle border me-3"
                                                     width="50" height="50"
                                                     style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center me-3"
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user text-secondary"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ $student->user->name ?? 'N/A' }}
                                                </div>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i>
                                                    {{ $student->user->email ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Student ID --}}
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                            {{ $student->student_id }}
                                        </span>
                                    </td>

                                    {{-- Class --}}
                                    <td>
                                        @if ($student->classroom)
                                            <div class="fw-semibold text-dark">
                                                <i class="fas fa-school text-primary me-1"></i>
                                                {{ $student->classroom->class_name }}
                                            </div>
                                            <small class="text-muted">
                                                Section - {{ $student->classroom->section }}
                                            </small>
                                        @else
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                                Not Assigned
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Phone --}}
                                    <td>
                                        <span class="text-dark">
                                            <i class="fas fa-phone text-success me-1"></i>
                                            {{ $student->phone ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Birth Date --}}
                                    <td>
                                        <span class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d M Y') : '-' }}
                                        </span>
                                    </td>

                                    {{-- Address --}}
                                    <td>
                                        <span class="text-dark">
                                            <i class="fas fa-location-dot text-danger me-1"></i>
                                            {{ $student->address ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Guardian --}}
                                    <td>
                                        <div class="fw-semibold text-dark">
                                            <i class="fas fa-user-shield text-warning me-1"></i>
                                            {{ $student->guardian_name ?? '-' }}
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-phone me-1"></i>
                                            {{ $student->guardian_phone ?? '-' }}
                                        </small>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @if ($student->user && $student->user->status == 'active')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                                <i class="fas fa-circle me-1 small"></i> Active
                                            </span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                                <i class="fas fa-circle me-1 small"></i> Inactive
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{route('students.show',$student->id)}}"
                                               class="btn btn-sm btn-info text-white rounded-3"
                                               title="View Student">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{route('students.edit',$student->id)}}"
                                               class="btn btn-sm btn-warning text-dark rounded-3"
                                               title="Edit Student">
                                                <i class="fas fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{route('students.destroy',$student->id)}}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this student?');"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger rounded-3"
                                                        title="Delete Student">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer --}}
                <div class="card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <small class="text-muted">
                        <i class="fas fa-database me-1"></i>
                        Total Students: <strong>{{ $students->total() }}</strong>
                    </small>

                    <div>
                        {{ $students->links() }}
                    </div>
                </div>

            @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-user-graduate fa-3x text-secondary opacity-50"></i>
                    </div>
                    <h5 class="fw-bold text-dark">No Students Found</h5>
                    <p class="text-muted mb-4">There are no students added yet. Start by creating the first student.</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary rounded-3 px-4">
                        <i class="fas fa-user-plus me-2"></i> Add First Student
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
