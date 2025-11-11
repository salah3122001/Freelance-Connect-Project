@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container mt-4">

        <h2 class="mb-4">All Services</h2>

        @forelse ($services as $service)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">

                    <h4>
                        <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none">
                            {{ $service->title }}
                        </a>
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
                    {{-- @endif --}}

                </div>
            </div>
            @empty
            <p><b>No Services Yet</b></p>
        @endforelse

    </div>
@endsection
