<?php

namespace App\Mail;

use App\Models\ApplicationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\ApplicationRequest  $application
     * @return void
     */
    public function __construct(ApplicationRequest $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.application.confirmation')
                    ->with([
                        'userName' => $this->application->user->prenom . ' ' . $this->application->user->nom,
                        'formationTitle' => $this->application->formation->titre,
                        'confirmationUrl' => route('user.application.confirm', ['application' => $this->application, 'hash' => $this->application->hash]),
                    ]);
    }
}
