<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('service', compact('services'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imageName = time().'.'.$request->icon->extension();
        $request->icon->move(public_path('images'), $imageName);

        $service = new Service();
        $service->title = $request->title;
        $service->icon = $imageName;
        $service->description = $request->description;
        $service->status = $request->status;
        $service->save();

        return response()->json(['message' => 'Service added successfully']);
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
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
    
        return response()->json(['message' => 'Service updated successfully']);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $imagePath = public_path('images/'.$service->icon);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $service->delete();

        return redirect()->route('services.index')->with('alert-success', 'Service deleted successfully');
    }

}