<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ClientReviewController extends Controller
{

    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clientReview', compact('clients'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $clients = new Client();
        $clients->name = $request->name;
        $clients->image = $imageName;
        $clients->description = $request->description;
        $clients->save();

        return response()->json(['message' => 'Client added successfully']);
    }

    public function edit($id)
    {
        $clients = Client::findOrFail($id);
        return response()->json($clients);
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            // Delete old image if it exists
            if ($client->image) {
                Storage::delete('public/images/' . $client->image);
            }
            $client->image = $imageName;
        }

        $client->name = $request->name;
        $client->description = $request->description;
        $client->save();
    
        return response()->json(['message' => 'Client updated successfully']);
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $imagePath = public_path('images/'.$client->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $client->delete();

        return redirect()->route('clients.index')->with('alert-success', 'Client deleted successfully');
    }


}