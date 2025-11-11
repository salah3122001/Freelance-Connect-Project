@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>User Profile</h1>
@stop

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-body">
        <h4>{{ $user->name }}</h4>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>
        <p><strong>Status:</strong>
            <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                {{ $user->status }}
            </span>
        </p>

        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@stop
