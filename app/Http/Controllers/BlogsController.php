<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogsController extends Controller
{
    // public function sendEmail(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'subject' => 'required',
    //         'message' => 'required',
    //     ]);

    //     $contact = new ContactUs();
    //     $contact->name = $request->name;
    //     $contact->email = $request->email;
    //     $contact->subject = $request->subject;
    //     $contact->message = $request->message;
    //     $contact->save();

    //     // Send email to admin
    //     Mail::to('ajay.dicecoder104@gmail.com')->send(new ContactMail($contact->name, $contact->email, $contact->subject, $contact->message));

    //     // Send notification to user if authenticated
    //     if ($request->user()) {
    //         $request->user()->notify(new ContactUsNotification());
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Your message has been sent successfully!',
    //     ]);
    // }
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('blog', compact('blogs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'slug' => 'required|unique:blogs',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->image = $imageName;
        $blog->slug = $request->slug;
        $blog->description = $request->description;
        $blog->save();

        return response()->json(['message' => 'Blog added successfully']);
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            // Delete old image if it exists
            if ($blog->image) {
                Storage::delete('public/images/' . $blog->image);
            }
            $blog->image = $imageName;
        }

        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->description = $request->description;
        $blog->save();
    
        return response()->json(['message' => 'Blog updated successfully']);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $imagePath = public_path('images/'.$blog->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $blog->delete();

        return redirect()->route('blogs.index')->with('alert-success', 'Blog deleted successfully');
    }

}