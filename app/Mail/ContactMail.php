<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $message;

    public function __construct($name, $email, $subject, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function build()
{
    return $this->view('emails.contact')
                ->subject('Contact Us Email')
                ->with([
                    'name' => $this->name,
                    'email' => $this->email,
                    'subject' => $this->subject,
                    'message' => $this->message,
                ]);
}
}