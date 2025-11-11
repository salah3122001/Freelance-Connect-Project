<?php

namespace App\Http\Controllers;

use App\Services\PaymobService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $paymob;

    public function __construct(PaymobService $paymob)
    {
        $this->paymob = $paymob;
    }

    
    public function pay($orderId)
    {
        $order = Order::findOrFail($orderId);

        
        $authToken = $this->paymob->getAuthToken();
        if (!$authToken) {
            Log::error('Paymob auth token not obtained.');
            return back()->with('error', 'Failed to initialize payment.');
        }

        
        $paymobOrderId = $this->paymob->createOrder($authToken, $order->id, $order->amount);
        if (!$paymobOrderId) {
            Log::error('Paymob order creation failed for order ID: ' . $order->id);
            return back()->with('error', 'Failed to create Paymob order.');
        }

        
        $paymentKey = $this->paymob->getPaymentKey(
            $authToken,
            $paymobOrderId,
            $order->amount,
            $order->client ?? Auth::user()
        );

        if (!$paymentKey) {
            Log::error('Paymob payment key not obtained for order ID: ' . $order->id);
            return back()->with('error', 'Failed to create payment key.');
        }

       
        $iframeUrl = $this->paymob->getIframeUrl($paymentKey);

        
        $order->update([
            'payment_id' => $paymobOrderId,
            'payment_status' => 'pending',
        ]);

        
        return view('payment.iframe', compact('iframeUrl', 'order'));
    }

    
    public function callback(Request $request)
    {
        Log::info('Paymob Callback Triggered', $request->all());

        $success = $request->input('success');
        $paymobOrderId = $request->input('order'); 

        
        $order = Order::where('payment_id', $paymobOrderId)->first();

        if (!$order) {
            Log::error("❌ Order not found for Paymob order ID: {$paymobOrderId}");
            return response('Order not found', 404);
        }

        Log::info("✅ Found order ID: {$order->id} | Current status: {$order->payment_status}");

        
        if ($success === "true" || $success === true) {
            $order->update(['payment_status' => 'paid']);
            Log::info("💰 Order {$order->id} updated to PAID successfully!");
            return view('payment.success', compact('order'));
        }

        
        $order->update(['payment_status' => 'failed']);
        Log::warning("⚠️ Order {$order->id} marked as FAILED");
        return view('payment.failed', compact('order'));
    }


    public function processing()
    {
        return view('payment.processing');
    }
}
