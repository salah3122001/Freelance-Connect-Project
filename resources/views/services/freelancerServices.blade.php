@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container mt-4">

        <h2 class="mb-4">Your Services</h2>

        @foreach ($services as $service)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">

                    <h4>
                        <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none text-dark">
                            {{ $service->title }}
                        </a>

                        @if ($service->status == 'rejected')
                            <span class="badge bg-danger ms-2 px-3 py-2 rounded-pill" style="font-size: 0.85rem;">
                                <i class="fas fa-times-circle me-1"></i> Rejected
                            </span>
                        @elseif ($service->status == 'pending')
                            <span class="badge bg-warning text-dark ms-2 px-3 py-2 rounded-pill"
                                style="font-size: 0.85rem;">
                                <i class="fas fa-hourglass-half me-1"></i> Pending
                            </span>
                        @elseif ($service->status == 'approved')
                            <span class="badge bg-success ms-2 px-3 py-2 rounded-pill" style="font-size: 0.85rem;">
                                <i class="fas fa-check-circle me-1"></i> Approved
                            </span>
                        @endif
                    </h4>

                    <p class="mb-2"><strong>Description:</strong> {{ $service->description }}</p>
                    <p class="mb-2"><strong>Price:</strong> {{ $service->price }} EGP</p>
                    <p class="mb-2"><strong>Freelancer:</strong> {{ $service->freelancer->name }}</p>

                    @if (auth()->check() && auth()->user()->role == 'freelancer' && $service->freelance_id == auth()->user()->id)
                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('services.destroy', $service->id) }}" class="d-inline" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this service?')">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
@endsection
