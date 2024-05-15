<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Exception;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class QuotesController extends Controller
{
   
    public function index()
    {
        $quotes = Quote::latest()->simplePaginate(10);
        return view('quote', compact('quotes'));
    }

    // public function store(Request $request)
    // {
    //      $request->validate([
    //      'name' => 'required',
    //      'email' => 'required|email',
    //      'service' => 'required',
    //      'message' => 'required',
    //      ]);

    //      // Create a new ContactUs record
    //      $quote = new Quote();
    //      $quote->name = $request->name;
    //      $quote->email = $request->email;
    //      $quote->service = $request->service;
    //      $quote->message = $request->message;
    //      $quote->save();
    //      return back()->with("success", "Quotes Added Successfully.");
    // }

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
        $mail->Subject = $request->service;
        // $mail->Body = $request->message;
        // $mail->addCustomHeader('X-User-Email', $request->email);
        $mail->Body =   "User Name: " . $request->name . "<br><br>" .
                        // "User Email: " . $request->email . "<br><br>" .
                        "User Service: " . $request->service . "<br><br>" .
                        "User Message: " . $request->message ;

        // Add custom header after setting the body
        $mail->addCustomHeader('X-User-Email', $request->email);

        // print_r($mail->send());die;
        // Send email
        if (!$mail->send()) {
        return back()->with("error", "Email not sent.")->withErrors($mail->ErrorInfo);
        } else {
        // Validate the request
        $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'service' => 'required',
        'message' => 'required',
        ]);

        // Create a new ContactUs record
        $quote = new Quote();
        $quote->name = $request->name;
        $quote->email = $request->email;
        $quote->service = $request->service;
        $quote->message = $request->message;
        $quote->save();
        return back()->with("success", "Quotes Added Successfully.");
        }
        } catch (Exception $e) {
        return back()->with('error', 'Message could not be sent.');
        }
    }

    public function edit($id)
    {
        $quotes = Quote::findOrFail($id);
        return response()->json($quotes);
    }

    public function update(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        $quote->name = $request->name;
        $quote->email = $request->email;
        $quote->service = $request->service;
        $quote->message = $request->message;
        $quote->save();

        return response()->json(['message' => 'Quote updated successfully']);
    }

    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();

        return redirect()->route('quotes.index')->with('alert-success', 'Quote deleted successfully');
    }
}