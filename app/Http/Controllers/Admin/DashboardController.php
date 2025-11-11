<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $clients = User::where('role', 'client')->count();
        $freelancers = User::where('role', 'freelancer')->count();
        $activeUsers = User::where('status', 'active')->count();
        $bannedUsers = User::where('status', 'banned')->count();

        $pendingOrders = Order::where('payment_status', 'pending')->count();
        $paidOrders = Order::where('payment_status', 'paid')->count();

        $totalServices = Service::count();
        $pendingServices = Service::where('status', 'pending')->count();
        $approvedServices = Service::where('status', 'approved')->count();
        $rejectedServices = Service::where('status', 'rejected')->count();


        return view('admin.dashboard', compact(
            'clients',
            'freelancers',
            'activeUsers',
            'bannedUsers',
            'pendingOrders',
            'paidOrders',
            'totalServices',
            'pendingServices',
            'approvedServices',
            'rejectedServices',
        ));
    }

    public function lastservices()
    {
        $recentServices = Service::where('status', 'pending')->with('freelancer')->latest()->take(5)->get();
        return view('admin.services.pendingservices', compact('recentServices'));
    }

    public function charts()
    {
        
        $ordersByStatus = Order::select('payment_status', DB::raw('count(*) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status');

        
        $ordersMonthly = Order::select(DB::raw("MONTH(created_at) as month"), DB::raw("COUNT(*) as count"))
            ->groupBy('month')
            ->pluck('count', 'month');

        return view('admin.charts', compact(
            'ordersByStatus',
            'ordersMonthly',
        ));
    }

    public function approve($id)
    {
        $service = Service::findOrFail($id);
        $service->status = 'approved';
        $service->save();
        return back()->with('success', 'Service Approved successfully');
    }
    public function reject($id)
    {
        $service = Service::findOrFail($id);
        $service->status = 'rejected';
        $service->save();
        return back()->with('success', 'Service Rejected successfully');
    }

    public function allservices()
    {
        $services = Service::with('freelancer')->get();
        return view('admin.services.allservices', compact('services'));
    }
    public function approvedservices()
    {
        $services = Service::with('freelancer')->where('status', 'approved')->get();
        return view('admin.services.approvedservices', compact('services'));
    }
    public function rejectedservices()
    {
        $services = Service::with('freelancer')->where('status', 'rejected')->get();
        return view('admin.services.rejectedservices', compact('services'));
    }

    public function adminsearch(Request $request)
    {
        $searchKey = $request->input('adminlteSearch') ?? ''; // AdminLTE بيرسل name=search

        if (empty($searchKey)) {
            $services = Service::with('freelancer')->get();
        } else {
            $services = Service::with('freelancer')
                ->where('title', 'like', "%{$searchKey}%")
                ->orWhereHas('freelancer', function ($query) use ($searchKey) {
                    $query->where('name', 'like', "%{$searchKey}%");
                })
                ->get();
        }

        return view('admin.services.allservices', compact('services', 'searchKey'));
    }
}
