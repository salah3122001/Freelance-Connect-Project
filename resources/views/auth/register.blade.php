@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-center bg-success text-white fs-4 fw-semibold py-3">
                    {{ __('Create an Account') }}
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                       
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">{{ __('Name') }}</label>
                            <input id="name" type="text"
                                class="form-control form-control-lg @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus
                                placeholder="Enter your full name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email"
                                placeholder="Enter your email address">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                                required autocomplete="new-password" placeholder="Create a password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        
                        <div class="mb-3">
                            <label for="password-confirm"
                                class="form-label fw-semibold">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control form-control-lg"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Re-enter your password">
                        </div>

                        
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold">{{ __('Role') }}</label>
                            <select name="role" id="role"
                                class="form-select form-select-lg @error('role') is-invalid @enderror">
                                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                                <option value="freelancer" {{ old('role') == 'freelancer' ? 'selected' : '' }}>Freelancer
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg rounded-3">
                                {{ __('Register') }}
                            </button>
                        </div>

                        
                        <div class="text-center mt-3">
                            <p class="text-muted">
                                {{ __('Already have an account?') }}
                                <a href="{{ route('login') }}" class="text-success fw-semibold text-decoration-none">
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
