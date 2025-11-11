@extends('adminlte::page')

@section('title', 'All Services')

@section('content_header')
    <h1>Services</h1>
@stop

@section('content')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
     @if (!empty($searchKey))
                            <div class="alert alert-info">
                                Showing results for: <strong>{{ $searchKey }}</strong>
                            </div>
                        @endif
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">All Services</h3>
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
                                @if ($service->status == 'pending')
                                    <a href="{{ route('admin.service.approve', $service->id) }}"
                                        class="btn btn-success btn-sm">Approve</a>
                                    <form action="{{ route('admin.service.reject', $service->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">Reject</button>
                                    </form>
                                @elseif($service->status == 'approved')
                                    <b>Already Approved</b>
                                @else
                                    <b>Already Rejected</b>
                                    <a href="{{ route('admin.service.approve', $service->id) }}"
                                        class="btn btn-success btn-sm">Approve Now</a>
                                @endif

                            </td>
                            <td>{{ $service->created_at ? $service->created_at->format('Y-m-d') : '-' }}</td>
                        </tr>
                    @empty
                        <td colspan="6" class="text-center"><b>No Services Yet</b></td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


@stop
