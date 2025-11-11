@extends('adminlte::page')

@section('title', 'Rejected Services')

@section('content_header')
    <h1>Rejected Services</h1>
@stop

@section('content')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Rejected Services</h3>
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
                                <a href="{{ route('admin.service.approve', $service->id) }}"
                                    class="btn btn-success btn-sm">Approve</a>

                            </td>
                            <td>{{ $service->created_at ? $service->created_at->format('Y-m-d') : '-' }}</td>
                        </tr>
                        @empty
                        <td colspan="6" class="text-center"><b>No Rejected Services</b></td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


@stop
