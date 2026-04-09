<x-guest-layout>
    <div class="container py-5">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 col-lg-5">

                <!-- Card -->
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-md-5">

                        <!-- Logo / Title -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fa-solid fa-school text-primary fa-3x"></i>
                            </div>
                            <h2 class="fw-bold mb-1">Welcome Back</h2>
                            <p class="text-muted mb-0">Login to your School Management System</p>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-3" :status="session('status')" />

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

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="fa-solid fa-envelope text-primary me-2"></i>Email Address
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    class="form-control form-control-lg"
                                    placeholder="Enter your email"
                                >
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="fa-solid fa-lock text-primary me-2"></i>Password
                                </label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="form-control form-control-lg"
                                    placeholder="Enter your password"
                                >
                            </div>

                            <!-- Remember + Forgot -->
                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember_me"
                                    >
                                    <label class="form-check-label" for="remember_me">
                                        Remember me
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        <i class="fa-solid fa-key me-1"></i>Forgot Password?
                                    </a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                                </button>
                            </div>

                            <!-- Back Home -->
                            <div class="text-center">
                                <a href="/" class="text-decoration-none">
                                    <i class="fa-solid fa-arrow-left me-1"></i>Back to Home
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer text -->
                <div class="text-center mt-4 text-muted small">
                    <i class="fa-solid fa-school me-1"></i>
                    School Management System
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
