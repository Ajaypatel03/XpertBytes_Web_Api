<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientReviewResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        return ClientReviewResource::collection(Client::all());
        // $client = Client::all();
        // return response()->json([
        //     'status' => true,
        //     'clients' => $client
        // ]);

        // $clients = Client::paginate(10);

        // if ($request->is('api/*')) {
        //     return response()->json([
        //         'status' => true,
        //         'posts' => $clients
        //     ]);
        // } else {
        //     return view('clientReview', compact('clients'));
        // }
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
            "description" => 'required'
        ]);

        // Save the image to the storage/app/public directory
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Create the blog entry
        $client = Client::create([
            "name" => $request->name,
            "image" => $imageName,
            "description" => $request->description
        ]);

        return response()->json([
            "status" => true,
            "message" => "Client Review Submmited Successfully In XB",
            "data" => $client
        ]);
    }

    public function show(Client $client)
    {
        return ClientReviewResource::make($client);
    }

   
    public function edit(Client $client)
    {
        //
    }

  
    public function update(Request $request, Client $client)
    {
        // Check if the client exists
        if (!$client) {
            abort(404);
        }

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            // Delete old image if it exists
            if ($client->image) {
            Storage::delete('public/images/' . $client->image);
            }
            $client->image = $imageName;
        }

        // Update the client fields
        $client->name = $request->name;
        $client->description = $request->description;

        // Save the changes to the database
        $client->save();

        return response()->json([
            'status' => true,
            'message' => 'Client Review Updated successfully!',
            'post' => $client
        ]);
    }



    public function destroy(Client $client)
    {
        // Delete the image file
        Storage::delete('public/' . $client->image);

        // Delete the client entry
        $client->delete();

        return response()->json([
            'status' => true,
            'message' => "Client Review Deleted successfully!",
        ], 200);
    }
}