@extends('layouts.master')
@section('title', 'Subjects')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-book-open text-primary me-2"></i>
                Subject Management
            </h2>
            <p class="text-muted mb-0">View, manage, and organize all school subjects.</p>
        </div>
        @role('admin')
            <div>
                <a href="{{route('admin.dashboard')}}" class="btn btn-outline-secondary rounded-3">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary rounded-3">
                <i class="fas fa-plus me-1"></i> Add New Subject
            </a>
            </div>
        @endrole
        @role('student')
            <a href="{{route('student.dashboard')}}" class="btn btn-outline-secondary rounded-3">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
        @endrole

    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
            <i class="fas fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Danger Message --}}
    @if (session('danger'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
            <i class="fas fa-circle-exclamation me-2"></i>
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-book me-2 text-primary"></i> Subject List
                </h5>


                <div class="w-100" style="max-width: 320px;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 bg-light" placeholder="Search subject...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">

            @if ($subjects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="py-3">Subject Name</th>
                                <th class="py-3">Subject Code</th>
                                <th class="py-3">Created At</th>
                                @role('admin')
                                <th class="py-3 text-center">Actions</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $index => $subject)
                                <tr>
                                    <td class="px-4 fw-semibold text-muted">
                                        {{ $subjects->firstItem() + $index }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                                 style="width: 45px; height: 45px;">
                                                <i class="fas fa-book text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $subject->subject_name }}</div>
                                                <small class="text-muted">School Subject</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2 border">
                                            {{ $subject->subject_code }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $subject->created_at ? $subject->created_at->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    @role('admin')
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Edit --}}
                                            <a href="{{route('admin.subjects.edit',$subject->id)}}"
                                               class="btn btn-sm btn-warning text-dark rounded-3"
                                               title="Edit Subject">
                                                <i class="fas fa-pen-to-square"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{route('admin.subjects.destroy',$subject->id)}}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this subject?');"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger rounded-3"
                                                        title="Delete Subject">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer --}}
                <div class="card-footer bg-white border-0 py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <small class="text-muted">
                        <i class="fas fa-database me-1"></i>
                        Total Subjects: <strong>{{ $subjects->total() }}</strong>
                    </small>

                    <div>
                        {{ $subjects->links() }}
                    </div>
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-book-open fa-3x text-secondary opacity-50"></i>
                    </div>
                    <h5 class="fw-bold text-dark">No Subjects Found</h5>
                    <p class="text-muted mb-4">There are no subjects added yet. Start by creating a new subject.</p>
                    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary rounded-3">
                        <i class="fas fa-plus me-2"></i> Add First Subject
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
