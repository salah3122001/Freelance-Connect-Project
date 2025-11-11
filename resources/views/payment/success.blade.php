@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <div class="alert alert-success shadow p-4 rounded">
        <h2>✅ Payment Approved Successfully</h2>
        <p>Your order <strong>#{{ $order->id ?? '' }}</strong> has been marked as <b>paid</b>.</p>
        <p>Thank you for your payment! 🎉</p>
        <a href="{{ route('orders.index') }}" class="btn btn-primary mt-3">Back to Orders</a>
    </div>
</div>
@endsection
