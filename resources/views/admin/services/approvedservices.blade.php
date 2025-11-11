@extends('adminlte::page')

@section('title', 'Approved Services')

@section('content_header')
    <h1>Approved Services</h1>
@stop

@section('content')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Approved Services</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Actions</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->freelancer->name }}</td>
                            <td>{{ ucfirst($service->status) }}</td>
                            <td>

                                <form action="{{ route('admin.service.reject', $service->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Reject</button>
                                </form>
                            </td>
                            <td>{{ $service->created_at ? $service->created_at->format('Y-m-d') : '-' }}</td>
                        </tr>
                        @empty
                        <td colspan="6" class="text-center"><b>No Approved Services</b></td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


@stop
