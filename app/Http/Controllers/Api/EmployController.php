<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployResource;
use App\Models\Employ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployController extends Controller
{
    public function index()
    {
        return EmployResource::collection(Employ::all());
        // $employ = Employ::all();
        // return response()->json([
        //     'status' => true,
        //     'employees' => $employ
        // ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|string',
            "image" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "designation" => 'required',
            // "status" => 'required',
        ]);

        // Save the image to the storage/app/public directory
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Create the blog entry
        $employ = Employ::create([
            "name" => $request->name,
            "image" => $imageName,
            "designation" => $request->designation,
            "status" => $request->status,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Employ Created Successfully In XB",
            "data" => $employ
        ]);
    }

   
    public function edit($id)
    {
        //
    }

    public function show(Employ $employ)
    {
      return EmployResource::make($employ);
    }
  
    public function update(Request $request,$id)
    {
         $employ = Employ::find($id);
        // Check if the client exists
        if (!$employ) {
            abort(404);
        }

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            // Delete old image if it exists
            if ($employ->image) {
            Storage::delete('public/images/' . $employ->image);
            }
            $employ->image = $imageName;
        }

        // Update the client fields
        $employ->name = $request->name;
        $employ->designation = $request->designation;
        $employ->status = $request->status;

        // Save the changes to the database
        $employ->save();

        return response()->json([
            'status' => true,
            'message' => 'Employ Updated successfully!',
            'post' => $employ
        ]);
    }
    

    public function destroy(Employ $employ)
    {
        // Delete the image file
        Storage::delete('public/' . $employ->image);

        // Delete the client entry
        $employ->delete();

        return response()->json([
            'status' => true,
            'message' => "Employ Deleted successfully!",
        ], 200);
    }
}