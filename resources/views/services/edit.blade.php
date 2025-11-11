@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4">Edit Service</h2>

    <form action="{{ route('services.update', $service->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Service Title</label>
            <input type="text" name="title" class="form-control"
                value="{{ old('title', $service->title) }}">
            @error('title')
            <div class="alert alert-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Service Description</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description', $service->description) }}</textarea>
            @error('description')
            <div class="alert alert-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Service Price</label>
            <input type="number" name="price" class="form-control"
                value="{{ old('price', $service->price) }}">
            @error('price')
            <div class="alert alert-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Update Service</button>
    </form>
</div>

@endsection
