@extends('layouts.master')
@section('title','Techers')

@section('content')
<div class="container py-4">


    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                Teachers Management
            </h2>
            <p class="text-muted mb-0">View, edit, and manage all teachers in the system.</p>
        </div>
        <div>
             <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i> Add New Teacher
            </a>
        </div>

    </div>


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
            <i class="fas fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-list me-2 text-primary"></i>Teachers List
                </h5>


                <div class="w-100" style="max-width: 320px;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 bg-light" placeholder="Search teacher...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">

            @if($teachers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="py-3">Teacher</th>
                                <th class="py-3">Teacher ID</th>
                                <th class="py-3">Phone</th>
                                <th class="py-3">Specialization</th>
                                <th class="py-3">Hire Date</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $index => $teacher)
                                <tr>

                                    <td class="px-4 fw-semibold text-muted">
                                        {{ $index + 1 }}
                                    </td>


                                    <td>
                                        <div class="d-flex align-items-center">

                                            @if($teacher->user && $teacher->user->profile_photo)
                                                <img src="{{ asset('storage/' . $teacher->user->profile_photo) }}"
                                                     alt="Teacher Photo"
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
                                                    {{ $teacher->user->name ?? 'N/A' }}
                                                </div>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i>
                                                    {{ $teacher->user->email ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                            {{ $teacher->teacher_id }}
                                        </span>
                                    </td>


                                    <td>
                                        <span class="text-dark">
                                            <i class="fas fa-phone text-success me-1"></i>
                                            {{ $teacher->phone ?? '-' }}
                                        </span>
                                    </td>


                                    <td>
                                        <span class="text-dark">
                                            <i class="fas fa-book-open text-info me-1"></i>
                                            {{ $teacher->specialization ?? '-' }}
                                        </span>
                                    </td>


                                    <td>
                                        <span class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $teacher->hire_date ? \Carbon\Carbon::parse($teacher->hire_date)->format('d M Y') : '-' }}
                                        </span>
                                    </td>


                                    <td>
                                        @if($teacher->user->status == 'active')
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fas fa-circle me-1 small"></i> Active
                                            </span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2">
                                                <i class="fas fa-circle me-1 small"></i> Inactive
                                            </span>
                                        @endif
                                    </td>


                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{route('admin.teachers.show',$teacher->id)}}"
                                               class="btn btn-sm btn-info text-light rounded-3"
                                               title="View Teacher">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{route('admin.teachers.edit',$teacher->id)}}"
                                               class="btn btn-sm btn-warning text-dark rounded-3"
                                               title="Edit Teacher">
                                                <i class="fas fa-pen-to-square"></i>
                                            </a>


                                            <form action="{{route('admin.teachers.destroy',$teacher->user_id)}}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this teacher?');"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger rounded-3"
                                                        title="Delete Teacher">
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


                <div class="card-footer bg-white border-0 py-3 px-4">
                    <small class="text-muted">
                        <i class="fas fa-database me-1"></i>
                        Total Teachers: <strong>{{ $teachers->count() }}</strong>
                    </small>
                </div>
            @else

                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-chalkboard-teacher fa-3x text-secondary opacity-50"></i>
                    </div>
                    <h5 class="fw-bold text-dark">No Teachers Found</h5>
                    <p class="text-muted mb-4">There are no teachers added yet. Start by creating a new teacher.</p>
                    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i> Add First Teacher
                    </a>
                </div>
            @endif

        </div>
    </div>
<div class="d-flex justify-content-center mt-4 text-center">
            {{ $teachers->links() }}
        </div>
</div>

@endsection
