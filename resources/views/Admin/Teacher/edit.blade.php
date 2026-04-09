@extends('layouts.master')
@section('title', 'Edit Teacher')
@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                    Edit Teacher Info
                </h2>
                <p class="text-muted mb-0">Edit a teacher account and profile information.</p>
            </div>
            <div>
           <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
             <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-back me-1"></i> Teachers
            </a>
            </div>

        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <i class="fas fa-circle-check me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0 rounded-3">
                <div class="fw-semibold mb-2">
                    <i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Teacher Registration Form
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('teachers.update',$teacher->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="u_id" value="{{$teacher->user_id}}">
                    <div class="mb-4">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-user-circle me-2"></i>Account Information
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-1 text-primary"></i> Full Name
                                </label>
                                <input type="text" name="name" class="form-control rounded-3"
                                    value="{{ $teacher->user->name }}" placeholder="enter your name" required>
                            </div>







                    <div class="mb-4">
                        <h5 class="fw-bold text-success border-bottom pb-2 mb-3">
                            <i class="fas fa-id-badge me-2"></i>Teacher Information
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-phone me-1 text-success"></i> Phone Number
                                </label>
                                <input type="text" name="phone" class="form-control rounded-3"
                                    value="{{ $teacher->phone }}" placeholder="Enter phone number">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-book-open me-1 text-success"></i> Specialization
                                </label>
                                <input type="text" name="specialization" class="form-control rounded-3"
                                    value="{{ $teacher->specialization }}" placeholder="e.g. Mathematics">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1 text-success"></i> Hire Date
                                </label>
                                <input type="date" name="hire_date" class="form-control rounded-3"
                                    value="{{ $teacher->hire_date }}">
                            </div>



                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-location-dot me-1 text-success"></i> Address
                                </label>
                                <input type="text" name="address" class="form-control rounded-3"
                                    value="{{ $teacher->address }}" placeholder="Enter address">
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ url()->previous() }}" class="btn btn-light border rounded-3 px-4">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="reset" class="btn btn-warning text-dark rounded-3 px-4">
                            <i class="fas fa-rotate-left me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">
                            <i class="fas fa-edit me-1"></i> Edit Teacher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
