@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h2 class="mb-3">{{ $service->title }}</h2>

                <p><strong>Description:</strong> {{ $service->description }}</p>
                <p><strong>Price:</strong> ${{ $service->price }}</p>
                <p><strong>Freelancer:</strong> {{ $service->freelancer->name }}</p>

            </div>
        </div>

       


        @if (auth()->user()->clientOrders()->where('service_id', $service->id)->exists())
            <div class="alert alert-info">✅ You already ordered this service</div>
        @elseif($service->freelance_id != auth()->user()->id)
            <form action="{{ route('orders.store', $service->id) }}" method="POST">
                @csrf
                <button class="btn btn-success">Order Now</button>
            </form>
        @endif



        
        @if (auth()->check() && auth()->user()->role == 'freelancer' && $service->freelance_id == auth()->user()->id)
            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning">Edit Service</a>

            <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Delete this service?')">
                    Delete Service
                </button>
            </form>
        @endif
    </div>
@endsection
