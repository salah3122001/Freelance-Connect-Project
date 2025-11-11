@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1 class="text-bold">Dashboard Overview</h1>
@stop

@section('content')


<div class="row mb-3">
    <div class="col-12">
        <h5 class="text-muted mb-2">Users Summary</h5>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-primary shadow-sm">
            <div class="inner">
                <h3>{{ $clients }}</h3>
                <p>Clients</p>
            </div>
            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
            <a href="{{ route('admin.clients') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3>{{ $freelancers }}</h3>
                <p>Freelancers</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.freelancers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ $activeUsers }}</h3>
                <p>Active Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3>{{ $bannedUsers }}</h3>
                <p>Banned Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-slash"></i>
            </div>
        </div>
    </div>
</div>


<div class="row mb-3">
    <div class="col-12">
        <h5 class="text-muted mb-2">Orders Summary</h5>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3>{{ $pendingOrders }}</h3>
                <p>Pending Orders</p>
            </div>
            <div class="icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ $paidOrders }}</h3>
                <p>Paid Orders</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-dark shadow-sm">
            <div class="inner">
                <h3>Charts</h3>
                <p>View Insights</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a class="small-box-footer" href="{{ route('admin.charts') }}">More Info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <h5 class="text-muted mb-2">Services Summary</h5>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-primary shadow-sm">
            <div class="inner">
                <h3>{{ $totalServices }}</h3>
                <p>Total Services</p>
            </div>
            <div class="icon">
                <i class="fas fa-th"></i>
            </div>
            <a class="small-box-footer" href="{{ route('admin.allservices') }}">View</a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3>{{ $pendingServices }}</h3>
                <p>Pending Services</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a class="small-box-footer" href="{{ route('admin.pendingservices') }}">Review</a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ $approvedServices }}</h3>
                <p>Approved Services</p>
            </div>
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
            <a class="small-box-footer" href="{{ route('admin.approvedservices') }}">View</a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3>{{ $rejectedServices }}</h3>
                <p>Rejected Services</p>
            </div>
            <div class="icon">
                <i class="fas fa-times"></i>
            </div>
            <a class="small-box-footer" href="{{ route('admin.rejectedservices') }}">View</a>
        </div>
    </div>
</div>

@stop
