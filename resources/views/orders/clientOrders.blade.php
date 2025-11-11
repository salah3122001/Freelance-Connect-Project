@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">📦 My Orders</h2>
        </div>

        @if ($orders->count() > 0)
            <div class="card shadow-lg border-0 rounded-4 p-3">
                <table class="table align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Chat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="bg-light">
                                <td class="fw-bold">{{ $order->id }}</td>

                                <td>
                                    <a href="{{ route('services.show', $order->service->id) }}"
                                        class="fw-semibold text-decoration-none text-dark">
                                        {{ $order->service->title ?? 'N/A' }}
                                    </a>
                                </td>

                                <td class="fw-semibold">{{ $order->amount }} <small class="text-secondary">EGP</small></td>

                                <td>
                                    <span
                                        class="badge px-3 py-2
                                    @if ($order->payment_status == 'paid') bg-success
                                    @elseif($order->payment_status == 'pending') bg-warning text-dark
                                    @else bg-danger @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>

                                <td>
                                    @if ($order->payment_status == 'pending')
                                        <a href="{{ route('payment.pay', $order->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            Pay Now
                                        </a>
                                    @elseif ($order->payment_status == 'paid')
                                        ✅ Paid
                                    @else
                                        ❌ Failed
                                    @endif
                                </td>

                                <td>
                                    @if ($order->payment_status == 'paid')
                                        <a href="{{ route('orders.chat', $order->id) }}"
                                            class="btn btn-sm btn-success rounded-pill px-3">
                                            💬 Chat
                                        </a>
                                    @else
                                        <span class="text-muted">🔒 Locked</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf

                                        <button class="btn btn-danger" onclick="return confirm('Delete this order?')">
                                            Delete Order
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info mt-4 rounded-3 shadow-sm text-center py-3 fs-5">
                No Orders Yet.
            </div>
        @endif

    </div>
@endsection
