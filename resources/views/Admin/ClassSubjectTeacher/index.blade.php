@extends('layouts.master')
@section('title', 'Class Subject Teacher')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-diagram-project text-primary me-2"></i>
                Class Subject Teacher
            </h2>
            <p class="text-muted mb-0">
                Manage subject assignments for classes and teachers.
            </p>
        </div>
        <div>
        <a href="{{route('dashboard')}}" class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('class-subject-teachers.create') }}" class="btn btn-primary rounded-3">
            <i class="fas fa-plus me-1"></i> New Assignment
        </a>
        </div>

    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <i class="fas fa-circle-check me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    @endif

    @if(session('danger'))
       <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <i class="fas fa-circle-check me-2"></i>
                {{ session('danger') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    @endif

    {{-- Card --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-list me-2 text-primary"></i>Assignments List
            </h5>

            {{-- Search (optional UI) --}}
            <input type="text" class="form-control w-25" placeholder="Search...">
        </div>

        <div class="card-body p-0">

            @if($assignments->count() > 0)

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Academic Year</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($assignments as $index => $item)
                                <tr>

                                    {{-- Index --}}
                                    <td class="px-4 fw-semibold text-muted">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Class --}}
                                    <td>
                                        <div class="fw-semibold text-dark">
                                            {{ $item->classroom->class_name ?? 'N/A' }}
                                        </div>
                                        <small class="text-muted">
                                            Section {{ $item->classroom->section ?? '-' }}
                                        </small>
                                    </td>

                                    {{-- Subject --}}
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $item->subject->subject_name ?? 'N/A' }}
                                        </div>
                                        <small class="text-muted">
                                            Code: {{ $item->subject->subject_code ?? '-' }}
                                        </small>
                                    </td>

                                    {{-- Teacher --}}
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $item->teacher->user->name ?? 'N/A' }}
                                        </div>
                                        <small class="text-muted">
                                            ID: {{ $item->teacher->teacher_id ?? '-' }}
                                        </small>
                                    </td>

                                    {{-- Academic Year --}}
                                    <td>
                                        <span class="badge bg-info text-dark px-3 py-2">
                                            {{ $item->academic_year }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Edit --}}
                                            <a href="{{route('class-subject-teachers.edit',$item->id)}}"
                                               class="btn btn-sm btn-warning rounded-3"
                                               title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{route('class-subject-teachers.destroy',$item->id)}}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger rounded-3"
                                                        title="Delete">
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
                <div class="card-footer bg-white border-0 py-3 px-4">
                    <small class="text-muted">
                        Total Assignments:
                        <strong>{{ $assignments->count() }}</strong>
                    </small>
                </div>

            @else

                {{-- Empty --}}
                <div class="text-center py-5">
                    <i class="fas fa-diagram-project fa-3x text-muted mb-3"></i>
                    <h5 class="fw-bold">No Assignments Found</h5>
                    <p class="text-muted">Start by creating a new assignment.</p>

                    <a href="{{ route('class-subject-teachers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Assignment
                    </a>
                </div>

            @endif

        </div>
    </div>

</div>
@endsection
