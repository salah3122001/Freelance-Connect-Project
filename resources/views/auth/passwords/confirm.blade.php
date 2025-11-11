@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-center bg-warning text-white fs-4 fw-semibold py-3">
                    {{ __('Confirm Your Password') }}
                </div>

                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-4">
                        {{ __('Please confirm your password before continuing.') }}
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}" class="text-start">
                        @csrf

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                                required autocomplete="current-password" placeholder="Enter your password">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-warning text-white btn-lg rounded-3">
                                {{ __('Confirm Password') }}
                            </button>
                        </div>

                        {{-- Forgot Password --}}
                        @if (Route::has('password.request'))
                            <div class="text-center mt-3">
                                <a href="{{ route('password.request') }}"
                                    class="text-decoration-none text-warning fw-semibold">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
