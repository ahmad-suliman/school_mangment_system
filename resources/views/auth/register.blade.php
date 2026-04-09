<x-guest-layout>
    <div class="container py-5">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-10 col-lg-7">

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-md-5">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fa-solid fa-user-plus text-primary fa-3x"></i>
                            </div>
                            <h2 class="fw-bold mb-1">Create Account</h2>
                            <p class="text-muted mb-0">Register a new user in the School Management System</p>
                        </div>

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">

                                <!-- Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="fa-solid fa-user text-primary me-2"></i>Full Name
                                    </label>
                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                        class="form-control form-control-lg"
                                        placeholder="Enter full name"
                                    >
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fa-solid fa-envelope text-primary me-2"></i>Email Address
                                    </label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autocomplete="username"
                                        class="form-control form-control-lg"
                                        placeholder="Enter email"
                                    >
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-semibold">
                                        <i class="fa-solid fa-toggle-on text-primary me-2"></i>Status
                                    </label>
                                    <select
                                        id="status"
                                        name="status"
                                        class="form-select form-select-lg"
                                        required
                                    >
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <!-- Profile Picture -->
                                <div class="col-md-6">
                                    <label for="profile_picture" class="form-label fw-semibold">
                                        <i class="fa-solid fa-image text-primary me-2"></i>Profile Picture
                                    </label>
                                    <input
                                        id="profile_picture"
                                        type="file"
                                        name="profile_picture"
                                        class="form-control form-control-lg"
                                        accept="image/*"
                                    >
                                </div>

                                <!-- Password -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fa-solid fa-lock text-primary me-2"></i>Password
                                    </label>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        autocomplete="new-password"
                                        class="form-control form-control-lg"
                                        placeholder="Enter password"
                                    >
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="fa-solid fa-lock text-primary me-2"></i>Confirm Password
                                    </label>
                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        required
                                        autocomplete="new-password"
                                        class="form-control form-control-lg"
                                        placeholder="Confirm password"
                                    >
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa-solid fa-user-plus me-2"></i>Register
                                </button>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                <a href="{{ route('home') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-arrow-left me-1"></i>Back to Home
                                </a>

                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    <i class="fa-solid fa-right-to-bracket me-1"></i>Already have an account?
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4 text-muted small">
                    <i class="fa-solid fa-school me-1"></i>
                    School Management System
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
