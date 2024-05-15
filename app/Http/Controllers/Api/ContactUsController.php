<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactUsResource;
use App\Mail\ContactMail;
use App\Models\ContactUs;
use App\Notifications\ContactUsNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContactUsResource::collection(ContactUs::all());
        // $contactUs = ContactUs::all();
        // return response()->json([
        //     'status' => true,
        //     'clients' => $contactUs
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
{
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.dicecoder.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@dicecoder.com';
        $mail->Password = 'info@dicecoder';
        $mail->SMTPSecure = 'ssl'; // Use 'ssl' for port 465
        $mail->Port = 465;

        $mail->setFrom('info@dicecoder.com', $request->name);
        $mail->addAddress('ajay.dicecoder104@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = $request->subject;
        $mail->Body = $request->message;
        // print_r($request->email);die;
        // Send email
        if (!$mail->send()) {
            return back()->with("error", "Email not sent.")->withErrors($mail->ErrorInfo);
        } else {
            // Validate the request
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required',
            ]);

            // Create a new ContactUs record
            $contact = new ContactUs();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();

            // Show success message to user
            // return back()->with("success", "Email has been sent. We will connect with you soon.");
            return response()->json([
            'status' => true,
            'message' => "Email has been sent. We will connect with you soon."
            ]);
        }
    } catch (Exception $e) {
        return back()->with('error', 'Message could not be sent.');
    }
}


    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        return ContactUsResource::make($contactUs);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contactUs = ContactUs::findOrFail($id);
        return response()->json($contactUs);
    }

    public function update(Request $request, $id)
    {
        // Find the ContactUs record
        $contactUs = ContactUs::find($id);

        // Check if the ContactUs record exists
        if (!$contactUs) {
            abort(404);
        }

        // Update the ContactUs fields
        $contactUs->update([
            "name" => $request->name,
            "email" => $request->email,
            "mobileNo" => $request->mobileNo,
            "subject" => $request->subject,
            "message" => $request->message
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Updated successfully!',
            'post' => $contactUs
        ]);
    }


    public function destroy($id)
    {
        // Find the ContactUs record
        $contactUs = ContactUs::find($id);

        // Check if the ContactUs record exists
        if (!$contactUs) {
            abort(404);
        }

        // Delete the ContactUs record
        $contactUs->delete();

        return response()->json([
            'status' => true,
            'message' => "Deleted successfully!",
        ], 200);
    }

}