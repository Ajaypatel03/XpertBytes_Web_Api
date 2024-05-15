<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployController extends Controller
{
   public function index()
    {
        $employs = Employ::latest()->paginate(10);
        return view('employ', compact('employs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'designation' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $employ = new Employ();
        $employ->name = $request->name;
        $employ->image = $imageName;
        $employ->designation = $request->designation;
        $employ->status = $request->status;
        $employ->save();

        return response()->json(['message' => 'Employ added successfully']);
    }

    public function edit($id)
    {
        $employ = Employ::findOrFail($id);
        return response()->json($employ);
    }

    public function update(Request $request, $id)
    {
        $employ = Employ::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            // Delete old image if it exists
            if ($employ->image) {
                Storage::delete('public/images/' . $employ->image);
            }
            $employ->image = $imageName;
        }

        $employ->name = $request->name;
        $employ->designation = $request->designation;
        $employ->status = $request->status;
        $employ->save();
    
        return response()->json(['message' => 'Employ updated successfully']);
    }

    public function destroy($id)
    {
        $employ = Employ::findOrFail($id);
        $imagePath = public_path('images/'.$employ->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $employ->delete();

        return redirect()->route('employs.index')->with('alert-success', 'Employ deleted successfully');
    }
 
}