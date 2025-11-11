<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //

    public function index()
    {
        //
        $user = Auth::user();

        $orders = $user->clientOrders()->with('service', 'freelancer')->latest()->get();
        return view('orders.clientOrders', compact('orders'));
    }

    public function freelancerStatistics()
    {
        $user = Auth::user();
        $freelancerId = $user->id;

        $orders = $user->freelancerOrders()
            ->with('service', 'client')
            ->latest()
            ->get();

        $totalOrders = $orders->count();

        $completedOrders = $orders->where('payment_status', 'paid')->count();

        $pendingOrders = $orders->where('payment_status', 'pending')->count();

        $totalRevenue = $orders->where('payment_status', 'paid')->sum('amount'); // amount أو السعر اللي عندك

        $servicesCount = Service::where('freelance_id', $user->id)->count();




        $recentOrders = $orders->take(5);
        return view('orders.freelancerOrders', compact(
            'orders',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'totalRevenue',
            'recentOrders',
            'servicesCount'
        ));
    }
    public function create($id)
    {
        //
        $order = Order::findOrFail($id);
        return view('orders.create', compact('order'));
    }

    public function store(Request $request, $id)
    {
        //
        $request->validate([]);
        $service = Service::with('freelancer')->find($id);

        $order = new Order();
        $order->amount = $service->price;


        $order->client_id = Auth::user()->id;
        $order->freelance_id = $service->freelancer->id;
        $order->service_id = $service->id;
        $order->save();
        return redirect()->route('orders.index')->with('success', 'Order Added Successfully');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->route('orders.index')->with('success', 'Order Deleted Successfully');
    }

    public function get()
    {
        if (Auth::user()->role == 'freelancer') {
            $services = Service::where('freelance_id', Auth::user()->id)->get();
            return view('services.freelancerServices', compact('services'));
        }
        abort(403,'Unauthorized Access');

    }
}
