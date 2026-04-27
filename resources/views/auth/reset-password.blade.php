<x-guest-layout>

<div class="container py-5">
    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body p-4">

                    {{-- HEADER --}}
                    <div class="text-center mb-4">
                        <i class="fas fa-key fa-2x text-primary mb-2"></i>
                        <h4 class="fw-bold">Reset Your Password</h4>
                        <p class="text-muted small mb-0">
                            Enter your new password below
                        </p>
                    </div>

                    {{-- ERRORS --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM --}}
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        {{-- TOKEN --}}
                        <input type="hidden" name="token" value="{{ request()->route('token') }}">

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', request('email')) }}"
                                   class="form-control"
                                   required>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   required>
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Reset Password
                            </button>
                        </div>

                    </form>

                    {{-- BACK --}}
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none small">
                            ← Back to Login
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

</x-guest-layout>
