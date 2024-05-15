<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        return BlogResource::collection(Blog::all());
        // $blogs = Blog::paginate(10);

        // if ($request->is('api/*')) {
        //     return response()->json([
        //         'status' => true,
        //         'posts' => $blogs
        //     ]);
        // } else {
        //     return view('blog', compact('blogs'));
        // }


        // $blogs = Blog::all();
        //     return response()->json([
        //         'status' => true,
        //         'blogs' => $blogs
        //     ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => 'required|string',
            "image" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "slug" => 'required',
            "description" => 'required',
        ]);

        // Save the image to the storage/app/public directory
        // $imageName = time() . '.' . $request->image->extension();
        // $request->image->storeAs('public', $imageName);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        // Create the blog entry
        $blog = Blog::create([
            "title" => $request->title,
            "image" => $imageName,
            "slug" => $request->slug,
            "description" => $request->description,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Blog Created Successfully In XB",
            "data" => $blog
        ]);
    }

    public function show(Blog $blog)
    {
        return BlogResource::make($blog);
    }

    public function edit(Blog $blog)
    {
        //
    }

    public function update(Request $request, Blog $blog)
    {
        // Check if the blog exists
        if (!$blog) {
            abort(404);
        }

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $blog->image);
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $blog->image = $imageName;
        }

        // Update the blog fields
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->description = $request->description;

        // Call the update method without parentheses
        $blog->update();

        return response()->json([
            'status' => true,
            'message' => 'Blog Updated successfully!',
            'post' => $blog
        ]);
    }
    

    public function destroy(Blog $blog)
    {
        // Delete the image file
        Storage::delete('public/images/'. $blog->image);

        // Delete the blog entry
        $blog->delete();

        return response()->json([
            'status' => true,
            'message' => "Blog Deleted successfully!",
        ], 200);
    }

}