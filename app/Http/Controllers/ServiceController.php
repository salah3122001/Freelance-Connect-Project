<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $services = Service::with('freelancer')->where('status', 'approved')->get();
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|min:1',
            'price' => 'required|numeric|min:1',
            'description' => 'min:1',
        ]);

        $service = new Service();
        $service->title = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->freelance_id = Auth::user()->id;
        $service->status = 'pending';
        $service->save();
        return redirect()->route('services.index')->with('success', 'Service Created Successfully Please Wait Your Service To Be Approved');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $service = Service::findOrFail($id);

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $service = Service::find($id);
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'title' => 'required|min:1',
            'price' => 'required|numeric|min:1',
            'description' => 'min:1',
        ]);
        $service = Service::find($id);

        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('services.show', $id)->with('success', 'Service Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Service::findOrFail($id)->delete();
        return redirect()->route('services.index')->with('success', 'Service Deleted Successfully');
    }

    public function search(Request $request)
    {
        $searchKey = $request->searchkey;


        $services = Service::where('title', 'like', "%$searchKey%")->get();

        return view('services.index', compact('services', 'searchKey'));
    }
}
