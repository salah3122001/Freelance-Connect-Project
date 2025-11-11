@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-center bg-info text-white fs-4 fw-semibold py-3">
                    {{ __('Verify Your Email Address') }}
                </div>

                <div class="card-body text-center p-4">
                    @if (session('resent'))
                        <div class="alert alert-success rounded-3">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p class="fs-6 text-muted mb-4">
                        {{ __('Before proceeding, please check your email for a verification link.') }}<br>
                        {{ __('If you did not receive the email, you can request another below.') }}
                    </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-info text-white px-4 py-2 fw-semibold rounded-3">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <div class="mt-4">
                        <a href="{{ route('logout') }}" class="text-decoration-none text-secondary"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
