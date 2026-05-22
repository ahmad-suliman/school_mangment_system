@extends('layouts.master')
@section('title', 'Announcements')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-bullhorn text-primary me-2"></i>
                Announcements
            </h2>
            <p class="text-muted mb-0">Manage school announcements for students and teachers.</p>
        </div>

        <div class="d-flex gap-2">

            @role('admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Dashboard
                </a>

                <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus me-1"></i> New Announcement
                </a>
            @endrole

            @role('teacher')
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Dashboard
                </a>
                <a href="{{ route('teacher.announcements.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus me-1"></i> New Announcement
                </a>
            @endrole

            @role('student')
                <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Dashboard
                </a>
            @endrole

        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
        @if(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('danger') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD --}}
    <div class="card border-0 shadow-sm rounded-4">

        {{-- TOP BAR --}}
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">

                <h5 class="fw-bold mb-0">
                    <i class="fas fa-list text-primary me-2"></i>
                    All Announcements
                </h5>

                <input type="text" class="form-control w-25 bg-light border-0"
                       placeholder="Search announcement...">

            </div>
        </div>

        {{-- BODY --}}
        <div class="card-body p-0">

            @if($announcements->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4">#</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>To</th>
                                <th>Date</th>

                                @role('admin')
                                <th class="text-center">Actions</th>
                                @endrole
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($announcements as $announcement)
                                <tr>

                                    {{-- ID --}}
                                    <td class="px-4 text-muted fw-semibold">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- TITLE --}}
                                    <td class="fw-bold">
                                        {{ $announcement->title }}
                                    </td>

                                    {{-- MESSAGE --}}
                                    <td class="text-muted">
                                        {{ \Str::limit($announcement->message, 60) }}
                                    </td>

                                    {{-- TARGET --}}
                                    <td>
                                        <span class="badge bg-info text-dark px-3 py-2">
                                            {{ $announcement->target ?? 'All' }}
                                        </span>
                                    </td>

                                    {{-- DATE --}}
                                    <td class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $announcement->created_at->format('d M Y') }}
                                    </td>

                                    {{-- ACTIONS --}}
                                    @role('admin')
                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Delete this announcement?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-sm btn-danger">
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

                {{-- FOOTER --}}
                <div class="card-footer bg-white border-0 py-3 text-center">
                    {{ $announcements->links() }}
                </div>

            @else

                {{-- EMPTY STATE --}}
                <div class="text-center py-5">

                    <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>

                    <h5 class="fw-bold">No Announcements Yet</h5>

                    <p class="text-muted">Create your first announcement for students and teachers.</p>

                    @role('admin')
                        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Create Announcement
                        </a>
                    @endrole

                </div>

            @endif

        </div>
    </div>

</div>
@endsection
