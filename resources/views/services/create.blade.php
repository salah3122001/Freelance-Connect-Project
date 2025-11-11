@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-0 text-center">
                    <h3 class="fw-bold text-primary">➕ Create New Service</h3>
                </div>

                <div class="card-body">

                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Service Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter service title" value="{{ old('title') }}">
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Service Description</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Describe your service...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Price (EGP)</label>
                            <input type="number" name="price" class="form-control" placeholder="Enter price" value="{{ old('price') }}">
                            @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary w-100 fw-bold py-2 rounded-3">Create Service</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
