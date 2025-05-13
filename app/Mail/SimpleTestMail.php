<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimpleTestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // This will hold the user data to send in the email

    /**
     * Create a new message instance.
     *
     * @param  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Test Email') // Set the subject
                    ->view('emails.simpleTest') // Specify the view for the email
                    ->with([
                        'userName' => "srayem", // Pass user data to the view
                    ]);
    }
}
