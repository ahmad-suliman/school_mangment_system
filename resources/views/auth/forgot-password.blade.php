<x-guest-layout>

<div class="container py-5">
    <div class="row justify-content-center">
        <div>
            <a href="{{url()->previous()}}" class="btn btn-outline-dark">Back</a>
        </div>
        <div class="col-md-6">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">

                    <h4 class="fw-bold mb-3">Forgot Password</h4>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <input type="email" name="email"
                               class="form-control mb-3"
                               placeholder="Enter your email"
                               required>

                        <button class="btn btn-primary w-100">
                            Send Reset Link
                        </button>
                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

</x-guest-layout>
