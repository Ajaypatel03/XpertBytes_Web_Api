<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        return ServiceResource::collection(Service::all());
        // $Service = Service::all();
        // return response()->json([
        //     'status' => true,
        //     'Services' => $Service
        // ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required',
            'status' => 'required',
        ]);

        $imageName = time().'.'.$request->icon->extension();
        $request->icon->move(public_path('images'), $imageName);

        $service = new Service();
        $service->title = $request->title;
        $service->icon = $imageName;
        $service->description = $request->description;
        $service->status = $request->status;
        $service->save();

        return response()->json([
            "status" => true,
            "message" => "Service Created Successfully In XB",
            "data" => $service
        ]);
    }

   
    public function edit($id)
    {
        //
    }

    public function show(Service $service){

        return ServiceResource::make($service);
    }
  
    public function update(Request $request,$id)
    {
        $service = Service::findOrFail($id);

        if ($request->hasFile('icon')) {
        $imageName = time().'.'.$request->icon->extension();
        $request->icon->move(public_path('images'), $imageName);
        // Delete old image if it exists
        if ($service->icon) {
        Storage::delete('public/images/' . $service->icon);
        }
        $service->icon = $imageName;
        }

        $service->title = $request->title;
        $service->description = $request->description;
        $service->status = $request->status;
        $service->save();

        return response()->json([
            'status' => true,
            'message' => 'Service Updated successfully!',
            'post' => $service
        ]);
    }
    

    public function destroy(Service $service)
    {
        // Delete the image file if it exists
        if ($service->icon) {
        Storage::delete('public/images/' . $service->icon);
        }

        // Delete the service entry
        $service->delete();

        return response()->json([
        'status' => true,
        'message' => "Service Deleted successfully!",
        ], 200);
    }

}