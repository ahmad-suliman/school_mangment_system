@extends('layouts.master')
@section('title', 'Add Class')
@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fa-solid fa-school text-primary me-2"></i>
                    Add New Class
                </h2>
                <p class="text-muted mb-0">Create a Class Grade and Section.</p>
            </div>
            <div>

            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
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
                    <i class="fa-solid fa-chalkboard"></i> Class Deatiels
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('classes.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="fa-solid fa-building-columns"></i> Class Information
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fa-brands fa-square-odnoklassniki text-primary"></i> Class Name
                                </label>
                                <select name="class_name" class="form-select rounded-3" required>
                                    <option value="">Select Class</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="Grade{{ $i }}"
                                            {{ old('class_name') == $i ? 'selected' : '' }}>
                                            Grade {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fa-solid fa-section text-primary"></i> Section
                                </label>
                                <select name="section" class="form-select rounded-3 @error('section') is-invalid @enderror"
                                    required>
                                    <option value="">Select Section</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>

                            @php
                                $currentYear = date('Y');
                            @endphp

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1 text-primary"></i> Academic Year
                                </label>
                                <select name="academic_year" class="form-select rounded-3" required>
                                    <option value="">Select Academic Year</option>
                                    @for ($i = 0; $i < 5; $i++)
                                        @php
                                            $start = $currentYear + $i;
                                            $end = $start + 1;
                                            $year = $start . '-' . $end;
                                        @endphp
                                        <option value="{{ $year }}"
                                            {{ old('academic_year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
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
                            <i class="fas fa-save me-1"></i> Save Class
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
