@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <div class="shadow p-5 rounded bg-light">
        <h2 class="mb-4">⏳ Processing Your Payment...</h2>
        <p>Please wait while we confirm your transaction with Paymob.</p>

        <div class="spinner-border text-primary mt-4" role="status" style="width: 4rem; height: 4rem;">
            <span class="visually-hidden">Loading...</span>
        </div>

        <script>
            setTimeout(() => {
                window.location.href = "{{ route('orders.index') }}";
            }, 4000);
        </script>
    </div>
</div>
@endsection
