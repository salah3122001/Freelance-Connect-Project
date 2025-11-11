@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <h2 class="mb-4">💳 Complete Your Payment</h2>

        {{-- نعرض عنوان الخدمة ومبلغ الطلب --}}
        <p><strong>Service:</strong> {{ $order->service->title ?? 'Service' }}</p>
        <p><strong>Amount:</strong> {{ $order->amount }} EGP</p>

        {{-- لو الرابط موجود نعرض iframe الدفع --}}
        @if (isset($iframeUrl))
            <div class="mt-4 payment-frame-container">
                <iframe src="{{ $iframeUrl }}" frameborder="0" allowfullscreen></iframe>
            </div>
        @else
            {{-- لو حصل خطأ في إنشاء الرابط --}}
            <div class="alert alert-danger mt-3">
                Something went wrong while generating the payment link.
            </div>
        @endif
    </div>

    <style>
        /* ✅ خلي الصفحة تاخد مسافة سفلية كفاية */
        body {
            overflow-y: auto;
        }

        /* ✅ container للـ iframe */
        .payment-frame-container {
            position: relative;
            width: 100%;
            height: 80vh; /* ياخد 80% من ارتفاع الشاشة */
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* ✅ iframe مرن وياخد كل المساحة */
        .payment-frame-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* 📱 Responsive tweak */
        @media (max-width: 768px) {
            .payment-frame-container {
                height: 70vh;
            }
        }
    </style>
@endsection
