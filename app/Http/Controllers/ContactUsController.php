<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Notifications\ContactUsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactMail;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ContactUsController extends Controller
{
    public function index()
    {
        $contactUs = ContactUs::latest()->simplePaginate(10);
        return view('contactUs', compact('contactUs'));
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
            // print_r($mail->send());die;
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
                    return back()->with("success", "Email has been sent.");
                }
        } catch (Exception $e) {
                return back()->with('error', 'Message could not be sent.');
            }
    }


    public function edit($id)
    {
        $contacts = ContactUs::findOrFail($id);
        return response()->json($contacts);
    }

    public function update(Request $request, $id)
    {
        $contact = ContactUs::findOrFail($id);

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
    
        return response()->json(['message' => 'Contact updated successfully']);
    }

    public function destroy($id)
    {
        $contact = ContactUs::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('alert-success', 'Contact deleted successfully');
    }


}