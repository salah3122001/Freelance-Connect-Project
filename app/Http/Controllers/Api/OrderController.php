<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $orders = Order::with('freelancer:id,name,email,role')->with('client:id,name,email,role')->get();


            return response()->json([
                'status' => 'success',
                'count' => $orders->count(),
                'data' => $orders,
            ], 200);
        } elseif ($user->role == 'freelancer') {
            $orders = Order::with('freelancer:id,name,email,role')->with('client:id,name,email,role')->where('freelance_id', $user->id)->get();
            

            if ($orders->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'data' => 'No Orders Found',

                ]);
            }
            return response()->json([
                'status' => 'success',
                'count' => $orders->count(),
                'data' => $orders,
            ], 200);
        } else {
            $orders = Order::with('freelancer:id,name,email,role')->with('client:id,name,email,role')->where('client_id', $user->id)->get();
            

            if ($orders->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'data' => 'No Orders Found',

                ]);
            }
            return response()->json([
                'status' => 'success',
                'count' => $orders->count(),
                'data' => $orders,
            ], 200);
        }
    }

    public function show($id)
    {

        $order = Order::with('freelancer:id,name,email,role')->with('client:id,name,email,role')->where('id', $id)->first();

       
        if (!$order || (Auth::user()->role !== 'admin' &&
            $order->freelance_id !== Auth::user()->id &&
            $order->client_id !== Auth::user()->id)) {
            return response()->json([
                'status' => 'error',
                'data' => 'No Orders Found Or It is\'t your ',

            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'service_id' => 'required|exists:services,id',
            'payment_method' => 'required|string|in:visa,cash',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $user = Auth::user();
        $service = Service::findOrFail($data['service_id']);

        $order = Order::create([
            'amount' => $service->price,
            'payment_status' => 'pending',
            'payment_method' => $data['payment_method'],
            'client_id' => $user->id,
            'freelance_id' => $service->freelance_id,
            'service_id' => $service->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order Created Successfully',
            'data' => $order->load('freelancer:id,name,email', 'client:id,name,email', 'service:id,title,price'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'payment_status' => 'sometimes|string|in:pending,paid,failed,cancelled',
            'payment_method' => 'sometimes|string|in:visa,paypal,cash',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors(),
            ], 422);
        }

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        
        if ($user->role === 'client' && $order->client_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You can only update your own orders',
            ], 403);
        }

        if ($user->role === 'freelancer' && $order->freelance_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You can only update your own orders',
            ], 403);
        }

        $data = $validator->validated();

        
        if ($user->role === 'admin') {
            
            $order->update($data);
        } elseif ($user->role === 'client') {
            
            if ($order->payment_status === 'pending' && isset($data['payment_status']) && $data['payment_status'] === 'cancelled') {
                $order->update(['payment_status' => 'cancelled']);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You cannot update this order status',
                ], 403);
            }
        } elseif ($user->role === 'freelancer') {
            
            return response()->json([
                'status' => 'error',
                'message' => 'Freelancers cannot change payment status',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
            'data' => $order->fresh(),
        ], 200);
    }


    public function destroy($id)
    {
        $user = Auth::user();
        $order = Order::findOrFail($id);

        if ($order->client_id == $user->id) {
            $order->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Service Deleted Successfully',
            ]);
        }


        return response()->json([
            'status' => 'error',
            'message' => 'Service not found or not yours',
        ], 404);
    }
}
