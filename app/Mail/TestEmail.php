<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        // You can pass any data to the email here if needed
    }

    public function build()
    {
        return $this->view('emails.test');  // We'll create this view in the next step
    }
}
