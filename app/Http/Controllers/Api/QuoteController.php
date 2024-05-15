<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Exception;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class QuoteController extends Controller
{
    public function index()
    {
        return QuoteResource::collection(Quote::all());
        // $Quote = Quote::all();
        // return response()->json([
        //     'status' => true,
        //     'Quotes' => $Quote
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         "name" => 'required|string',
    //         "email" => 'required|email|string',
    //         "service" => 'required|string',
    //         "message" => 'required'
    //     ]);

    //     // Create the blog entry
    //     $Quote = Quote::create([
    //         "name" => $request->name,
    //         "email" => $request->email,
    //         "service" => $request->service,
    //         "message" => $request->message
    //     ]);

    //     return response()->json([
    //         "status" => true,
    //         "message" => "Quote Saved Successfully In XB",
    //         "data" => $Quote
    //     ]);
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
            $mail->Body = "User Name: " . $request->name . "<br><br>" .
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
            // return back()->with("success", "Quotes Added Successfully.");
            return response()->json([
                "status" => true,
                "message" => "Quote Saved Successfully In XB , We Will Connect You Soon",
                "data" => $quote
            ]);
        }
        } catch (Exception $e) {
        return back()->with('error', 'Message could not be sent.');
        }
    }

    public function show(Quote $quote){

        return QuoteResource::make($quote);
    }


    public function update(Request $request, Quote $quote)
    {
        //return 'update';
        // header('Content-Type: application/json');
        // print_r($id); die;
        // Validate the request data
        // $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|email',
        //     'service' => 'required|string',
        //     'message' => 'required|string',
        // ]);

        // // Find the Quote record
        // $quote = Quote::find($id);

        // // Check if the Quote record exists
        // if (!$quote) {
        //     abort(404);
        // }
        // print_r($request->input('name'));
        // die;
        // Update the Quote fields
        $quote->update([
            'name' => $request->name,
            'email' => $request->email,
            'service' => $request->service,
            'message' => $request->message,
        ]);

        return QuoteResource::make($quote);

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Quote Updated successfully!',
        //     'quote' => $quote
        // ]);
    }



    public function destroy($id)
    {
        // Find the ContactUs record
        $Quotes = Quote::find($id);

        // Check if the ContactUs record exists
        if (!$Quotes) {
            abort(404);
        }

        // Delete the ContactUs record
        $Quotes->delete();

        return response()->json([
            'status' => true,
            'message' => "Quote Deleted successfully!",
        ], 200);
    }
}