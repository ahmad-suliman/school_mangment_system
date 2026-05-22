@extends('layouts.master')
@section('title', 'Create Announcement')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-bullhorn text-primary me-2"></i>
                Create Announcement
            </h2>
            <p class="text-muted mb-0">Send a new announcement to students and teachers.</p>
        </div>
        @role('admin')
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        @endrole
        @role('teacher')
        <a href="{{ route('teacher.announcements.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        @endrole
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

            <form action="{{ auth()->user()->hasRole('admin') ? route('admin.announcements.store') : route('teacher.announcements.store')}}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- TITLE --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title"
                               class="form-control bg-light border-0"
                               placeholder="Enter title" required>
                    </div>

                    {{-- TARGET --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Send To</label>
                        <select name="target_role" class="form-select bg-light border-0">
                            <option value="all">All</option>
                            <option value="student">Students</option>
                            <option value="teacher">Teachers</option>
                        </select>
                    </div>

                    {{-- MESSAGE --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Message</label>
                        <textarea name="message" rows="5"
                                  class="form-control bg-light border-0"
                                  placeholder="Write announcement..." required></textarea>
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-4 d-flex justify-content-end">
                    <button class="btn btn-primary px-4">
                        <i class="fas fa-paper-plane me-1"></i> Publish
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
