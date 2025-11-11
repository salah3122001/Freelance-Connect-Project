@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-center bg-danger text-white fs-4 fw-semibold py-3">
                    {{ __('Reset Your Password') }}
                </div>

                <div class="card-body p-4">
                    <p class="text-muted mb-4 text-center">
                        {{ __('Please enter your email and new password to reset your account password.') }}
                    </p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                                value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                                placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                                required autocomplete="new-password" placeholder="Enter new password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label for="password-confirm"
                                class="form-label fw-semibold">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control form-control-lg"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Re-enter new password">
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-danger btn-lg text-white rounded-3">
                                {{ __('Reset Password') }}
                            </button>
                        </div>

                        {{-- Login link --}}
                        <div class="text-center mt-3">
                            <p class="text-muted">
                                {{ __('Remembered your password?') }}
                                <a href="{{ route('login') }}" class="text-danger fw-semibold text-decoration-none">
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
