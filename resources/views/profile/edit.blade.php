@extends('layouts.master')

@section('title', 'Edit Profile')

@section('content')
    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">
                <i class="fas fa-user-cog text-primary me-2"></i>
                Edit Profile
            </h3>
            <div>
                <a href="/profile" class="btn btn-sm btn-primary">Profile</a>
            </div>
        </div>

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <i class="fas fa-circle-check me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">

            {{-- LEFT: PROFILE CARD --}}
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-4">

                    {{-- PHOTO --}}
                    @if (auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="rounded-circle mb-3"
                            width="120" height="120" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width:120px;height:120px;">
                            <i class="fas fa-user fa-3x text-secondary"></i>
                        </div>
                    @endif

                    <h5 class="fw-bold">{{ auth()->user()->name }}</h5>

                    {{-- ROLE --}}
                    <span class="badge bg-primary mt-2">
                        {{ auth()->user()->roles->first()->name ?? 'User' }}
                    </span>

                </div>
            </div>

            {{-- RIGHT: FORM --}}
            <div class="col-md-8">
                <div class="card shadow-sm">

                    <div class="card-header bg-white fw-bold">
                        Update Information
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            {{-- NAME --}}
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                    class="form-control">
                            </div>

                            {{-- EMAIL --}}
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="form-control">
                            </div>

                            {{-- PHOTO --}}
                            <div class="mb-3">
                                <label class="form-label">Profile Photo</label>
                                <input type="file" name="profile_photo" class="form-control">
                            </div>

                            {{-- PASSWORD --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>

                            {{-- BUTTON --}}
                            <button class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Profile
                            </button>

                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
