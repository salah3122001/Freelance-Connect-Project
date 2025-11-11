@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-center bg-secondary text-white fs-4 fw-semibold py-3">
                    {{ __('Reset Your Password') }}
                </div>

                <div class="card-body p-4">
                    {{-- Success message --}}
                    @if (session('status'))
                        <div class="alert alert-success rounded-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4 text-center">
                        {{ __('Enter your email address and we will send you a password reset link.') }}
                    </p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-secondary btn-lg text-white rounded-3">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>

                        {{-- Login link --}}
                        <div class="text-center mt-3">
                            <p class="text-muted">
                                {{ __('Remember your password?') }}
                                <a href="{{ route('login') }}" class="text-secondary fw-semibold text-decoration-none">
                                    {{ __('Login here') }}
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
