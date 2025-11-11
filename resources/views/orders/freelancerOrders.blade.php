@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="fw-bold mb-4 text-center text-primary">📊 Freelancer Dashboard</h2>

        <div class="row mb-4 g-4">

            
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center border-0 rounded-4">
                    <div class="text-secondary">Total Orders</div>
                    <h2 class="fw-bold text-primary">{{ $totalOrders }}</h2>
                </div>
            </div>

            
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center border-0 rounded-4">
                    <div class="text-secondary">Completed</div>
                    <h2 class="fw-bold text-success">{{ $completedOrders }}</h2>
                </div>
            </div>

           
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center border-0 rounded-4">
                    <div class="text-secondary">In Progress</div>
                    <h2 class="fw-bold text-warning">{{ $pendingOrders }}</h2>
                </div>
            </div>


            
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center border-0 rounded-4">
                    <div class="text-secondary">Total Revenue</div>
                    <h2 class="fw-bold text-success">{{ $totalRevenue }} EGP</h2>
                </div>
            </div>

            {{-- My Services --}}
            <div class="col-md-3">
                <a href="{{ route('services.get') }}">
                    <div class="card shadow-sm p-3 text-center border-0 rounded-4">
                        <div class="text-secondary">My Services</div>
                        <h2 class="fw-bold text-info">{{ $servicesCount }}</h2>
                    </div>
                </a>
            </div>

        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-0">
                <h4 class="fw-bold text-secondary">🕑 Recent Orders</h4>
            </div>

            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Client</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Chat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td>{{ $order->client->name }}</td>
                                <td>{{ $order->service->title }}</td>
                                <td>
                                    <span
                                        class="badge
                                            @if ($order->payment_status == 'paid') bg-success
                                            @elseif($order->payment_status == 'pending') bg-warning
                                            @elseif($order->payment_status == 'rejected') bg-danger
                                            @else bg-secondary @endif
                                        ">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at ? $order->created_at->diffForHumans() : '-' }}</td>
                                <td>
                                    <a href="{{ route('orders.chat', $order->id) }}"
                                        class="btn btn-sm btn-success rounded-pill px-3">
                                        💬 Chat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
