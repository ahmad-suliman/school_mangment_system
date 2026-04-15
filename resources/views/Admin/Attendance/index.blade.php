@extends('layouts.master')
@section('title','Attendance List')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-calendar-check text-primary me-2"></i>
                Attendance Management
            </h2>
            <p class="text-muted mb-0">Manage and track student attendance records.</p>
        </div>
        <div>
            <a href="{{route('dashboard')}}" class="btn btn-outline-secondary rounded-3">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
            <a href="{{ route('attendance.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-1"></i> Take Attendance
            </a>
        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD --}}
    <div class="card border-0 shadow-sm rounded-4">

        {{-- TOP BAR --}}
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3">

                <h5 class="fw-bold mb-0">
                    <i class="fas fa-list text-primary me-2"></i>
                    Attendance List
                </h5>

                {{-- SEARCH --}}
                <div style="max-width: 300px;" class="w-100">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 bg-light"
                               placeholder="Search student...">
                    </div>
                </div>

            </div>
        </div>

        {{-- TABLE --}}
        <div class="card-body p-0">

            @if($attendances->count() > 0)
            <div class="table-responsive">

                <table class="table align-middle mb-0 table-hover">

                    <thead class="table-light">
                        <tr>
                            <th class="px-4">#</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($attendances as $item)
                        <tr>

                            {{-- INDEX --}}
                            <td class="px-4 text-muted fw-semibold">
                                {{ $loop->iteration }}
                            </td>

                            {{-- STUDENT --}}
                            <td>
                                <div class="d-flex align-items-center">

                                    {{-- IMAGE --}}
                                    @if($item->student->user->profile_photo)
                                        <img src="{{ asset('storage/'.$item->student->user->profile_photo) }}"
                                             class="rounded-circle me-3 border"
                                             width="45" height="45" style="object-fit:cover;">
                                    @else
                                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center me-3"
                                             style="width:45px;height:45px;">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                    @endif

                                    {{-- NAME --}}
                                    <div>
                                        <div class="fw-bold">
                                            {{ $item->student->user->name ?? 'N/A' }}
                                        </div>
                                        <small class="text-muted">
                                            ID: {{ $item->student->student_id }}
                                        </small>
                                    </div>

                                </div>
                            </td>

                            {{-- CLASS --}}
                            <td>
                                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                    {{ $item->classroom->class_name ?? '-' }}
                                </span>
                            </td>

                            {{-- SUBJECT --}}
                            <td>
                                <span class="text-dark fw-semibold">
                                    {{ $item->subject->subject_name ?? '-' }}
                                </span>
                            </td>

                            {{-- TEACHER --}}
                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-user-tie me-1 text-info"></i>
                                    {{ $item->teacher->user->name ?? '-' }}
                                </span>
                            </td>

                            {{-- DATE --}}
                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($item->status == 'present')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Present
                                    </span>
                                @elseif($item->status == 'absent')
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i> Absent
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-clock me-1"></i> Late
                                    </span>
                                @endif
                            </td>

                            {{-- ACTIONS --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('attendance.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning rounded-3">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <form action="{{ route('attendance.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger rounded-3">
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
            <div class="card-footer bg-white border-0 py-3 text-center">
                {{ $attendances->links() }}
            </div>

            @else

            {{-- EMPTY STATE --}}
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold">No Attendance Records</h5>
                <p class="text-muted">Start by taking attendance.</p>

                <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Take Attendance
                </a>
            </div>

            @endif

        </div>
    </div>

</div>
@endsection
