@extends('layouts.master')
@section('title', 'Edit Student')
@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fa-solid fa-user-graduate text-primary me-2"></i>
                   Edit Student
                </h2>
                <p class="text-muted mb-0">Edit a student account and profile information.</p>
            </div>
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Students
            </a>
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
                    <i class="fa-solid fa-user-group me-2"></i> Student Info
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('students.update',$student->id) }}" method="POST" >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{$student->user_id}}">
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
                                    value="{{ $student->user->name }}" placeholder="Enter full name" required>
                            </div>

                        </div>
                    </div>


                    <div class="mb-4">
                        <h5 class="fw-bold text-success border-bottom pb-2 mb-3">
                            <i class="fas fa-id-badge me-2"></i>Student Information
                        </h5>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fa-solid fa-door-open me-1 text-success"></i> Class Name
                                </label>
                                <select name="class_id" class="form-select rounded-3" required>
                                    <option value="">Select Class</option>
                                    @foreach ($classroom as $item)
                                        <option value="{{ $item->id }}" {{$student->class_id == $item->id ? 'selected' : ''}}>
                                            {{ $item->class_name }} - Section {{$item->section}}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-phone me-1 text-success"></i> Phone Number
                                </label>
                                <input type="text" name="phone" class="form-control rounded-3"
                                    value="{{ $student->phone}}" placeholder="Enter phone number">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-book-open me-1 text-success"></i> Birth Date
                                </label>
                                <input type="date" name="birth_date" class="form-control rounded-3"
                                    value="{{ $student->birth_date }}" placeholder="Enter Birth Date ">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1 text-success"></i> Address
                                </label>
                                <input type="text" name="address" class="form-control rounded-3"
                                    value="{{ $student->address }}" placeholder="Enter Student Address">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-1 text-success"></i> guardian_name
                                </label>
                                <input type="text" name="guardian_name" class="form-control rounded-3"
                                    value="{{ $student->guardian_name }}" placeholder="Enter guardian_name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-phone me-1 text-success"></i> guardian_phone
                                </label>
                                <input type="text" name="guardian_phone" class="form-control rounded-3"
                                    value="{{ $student->guardian_phone }}" placeholder="guardian_phone">
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
                            <i class="fas fa-save me-1"></i> Edit Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
