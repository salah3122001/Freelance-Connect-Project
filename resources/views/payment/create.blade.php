@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>💳 Payment for: {{ $order->service->title ?? 'Service' }}</h2>
        <p><strong>Amount:</strong> ${{ $order->amount }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</p>

        @if ($order->payment_status === 'paid')
            <div class="alert alert-success">This order is already paid ✅</div>
        @else
            <form action="{{ route('payment.store', $order->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="payment_method">Choose Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">-- Select --</option>
                        <option value="cash">Cash</option>
                        <option value="visa">Visa</option>
                        <option value="wallet">Wallet</option>
                    </select>
                    @error('payment_method')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary">Pay Now</button>
            </form>
        @endif
    </div>
@endsection
