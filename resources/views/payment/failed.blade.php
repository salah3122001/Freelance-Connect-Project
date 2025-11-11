@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <div class="alert alert-danger shadow p-4 rounded">
        <h2>❌ Payment Failed</h2>
        <p>Unfortunately, your payment for order <strong>#{{ $order->id ?? '' }}</strong> was not successful.</p>
        <p>Please try again later or use a different payment method.</p>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
    </div>
</div>
@endsection
