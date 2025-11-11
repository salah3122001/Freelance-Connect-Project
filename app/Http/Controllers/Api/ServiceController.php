<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $services = Service::with('freelancer:name,email,role')->get();
            

            return response()->json([
                'status' => 'success',
                'count' => $services->count(),
                'data' => $services,
            ], 200);
        }

        $services = Service::with('freelancer:name,email,role')->where('freelance_id', $user->id)->get();
        

        if ($services->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'data' => 'No Services Found',

            ]);
        }
        return response()->json([
            'status' => 'success',
            'count' => $services->count(),
            'data' => $services,
        ], 200);
    }

    public function show($id)
    {

        $service = Service::findOrFail($id);

        if (!$service) {
            return response()->json([
                'status' => 'error',
                'data' => 'No Services Found',

            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $service,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:1',
            'price' => 'required|numeric|min:1',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $user = Auth::user();
        if ($user->role == 'client') {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden Action',
            ]);
        }

        $service = Service::create([
            'title' => $data['title'],
            'price' => $data['price'],
            'description' => $request->description,
            'freelance_id' => $user->id,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Service Created Successfully',
            'data' => $service,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|min:1',
            'price' => 'sometimes|required|numeric|min:1',
            'description' => 'sometimes|string|nullable',
            'status' => 'sometimes|string|in:approved,rejected,pending',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors(),
            ], 422);
        }

        $service = Service::where('id', $id)->first();
        
        if (!$service) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found',
            ], 404);
        }

        $data = $validator->validated();

        if ($user->role === 'freelancer') {
            
            if (!$request->has('description')) {
                $data['description'] = $service->description;
            }

            $service->update($data);
        } elseif ($user->role === 'admin') {
            $service->update([
                'status' => $request->status ?? $service->status,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden Action',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Service Updated Successfully',
            'data' => $service->fresh(), 
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $service = Service::findOrFail($id);

        if (!$service || $service->freelance_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found or not yours',
            ], 404);
        }

        if ($user->role !== 'freelancer') {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden Action',
            ], 403);
        }

        $service->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Service Deleted Successfully',
        ]);
    }
}
