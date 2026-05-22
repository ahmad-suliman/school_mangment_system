@extends('layouts.master')
@section('title', 'Edit Announcement')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-edit text-warning me-2"></i>
                Edit Announcement
            </h2>
            <p class="text-muted mb-0">Update announcement details.</p>
        </div>

        <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>

    </div>
        @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    {{-- CARD --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">

                    {{-- TITLE --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title"
                               value="{{ $announcement->title }}"
                               class="form-control bg-light border-0" required>
                    </div>

                    {{-- TARGET --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Send To</label>
                        <select name="target_role" class="form-select bg-light border-0">

                            <option value="all" {{ $announcement->target == 'all' ? 'selected' : '' }}>All</option>
                            <option value="student" {{ $announcement->target == 'student' ? 'selected' : '' }}>Students</option>
                            <option value="teacher" {{ $announcement->target == 'teacher' ? 'selected' : '' }}>Teachers</option>

                        </select>
                    </div>

                    {{-- MESSAGE --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Message</label>
                        <textarea name="message" rows="5"
                                  class="form-control bg-light border-0" required>
                            {{ $announcement->message }}
                        </textarea>
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-4 d-flex justify-content-end gap-2">

                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                    <button class="btn btn-warning px-4">
                        <i class="fas fa-save me-1"></i> Update
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
