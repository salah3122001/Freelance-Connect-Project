@extends('adminlte::page')

@section('title', 'Clients')

@section('content_header')
    <h1>All Users</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-info btn-sm">View</a>


                        @if ($user->status == 'active')
                            <a href="{{ route('admin.user.ban', $user->id) }}" class="btn btn-warning btn-sm">Ban</a>
                        @else
                            <a href="{{ route('admin.user.unban', $user->id) }}" class="btn btn-success btn-sm">Unban</a>
                        @endif

                        <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>

                </tr>
                @empty
                <td colspan="6" class="text-center"><b>No Users Services</b></td>
            @endforelse
        </tbody>
    </table>
@stop
