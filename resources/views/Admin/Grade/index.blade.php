@extends('layouts.master')
@section('title', 'Grades')

@section('content')
    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-chart-line text-primary me-2"></i>
                    Grades Management
                </h2>
                <p class="text-muted mb-0">Manage and track student grades easily.</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Dashboard
                    </a>
                <a href="{{ route('grades.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Grade
                </a>
            </div>

        </div>

        {{-- ALERT --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- CARD --}}
        <div class="card border-0 shadow-sm rounded-4">

            {{-- TOP BAR --}}
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-list me-2 text-primary"></i> Grades List
                    </h5>

                    {{-- SEARCH UI --}}
                    <div class="w-100" style="max-width: 300px;">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light" placeholder="Search...">
                        </div>
                    </div>

                </div>
            </div>

            {{-- TABLE --}}
            <div class="card-body p-0">

                @if ($grades->count() > 0)

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th>Student</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Marks</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($grades as $grade)
                                    <tr>

                                        {{-- INDEX --}}
                                        <td class="px-4 text-muted fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- STUDENT --}}
                                        <td>
                                            <div class="d-flex align-items-center">

                                                <div class="rounded-circle border overflow-hidden me-3"
                                                    style="width:40px; height:40px;">

                                                    @if ($grade->student && $grade->student->user && $grade->student->user->profile_photo)
                                                        <img src="{{ asset('storage/' . $grade->student->user->profile_photo) }}"
                                                            alt="profile photo" class="w-100 h-100"
                                                            style="object-fit: cover;">
                                                    @else
                                                        <div
                                                            class="d-flex align-items-center justify-content-center bg-light w-100 h-100">
                                                            <i class="fas fa-user text-secondary"></i>
                                                        </div>
                                                    @endif

                                                </div>

                                                <div>
                                                    <div class="fw-bold">
                                                        {{ $grade->student->user->name ?? 'N/A' }}
                                                    </div>
                                                </div>

                                            </div>
                                        </td>

                                        {{-- SUBJECT --}}
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                                {{ $grade->subject->subject_name }}
                                            </span>
                                        </td>

                                        {{-- TEACHER --}}
                                        <td>
                                            {{ $grade->teacher->user->name ?? '-' }}
                                        </td>

                                        {{-- MARKS --}}
                                        <td>
                                            <span class="fw-bold">
                                                {{ $grade->marks }}
                                            </span>
                                        </td>

                                        {{-- STATUS --}}
                                        <td>
                                            @if ($grade->marks >= 50)
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fas fa-check me-1"></i> Pass
                                                </span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2">
                                                    <i class="fas fa-times me-1"></i> Fail
                                                </span>
                                            @endif
                                        </td>

                                        {{-- ACTIONS --}}
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">

                                                <a href="{{ route('grades.edit', $grade->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <form action="{{ route('grades.destroy', $grade->id) }}" method="POST"
                                                    onsubmit="return confirm('Delete this grade?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-sm btn-danger">
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

                    {{-- PAGINATION --}}
                    <div class="p-3">
                        {{ $grades->links() }}
                    </div>
                @else
                    {{-- EMPTY STATE --}}
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                        <h5>No Grades Found</h5>
                        <p class="text-muted">Start by adding a new grade.</p>

                        <a href="{{ route('grades.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add First Grade
                        </a>
                    </div>

                @endif

            </div>

        </div>

    </div>
@endsection
