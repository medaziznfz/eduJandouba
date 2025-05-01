<?php

namespace App\Mail;

use App\Models\Demande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeDeclinedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;
    public $reason;

    public function __construct(Demande $demande, string $reason)
    {
        $this->demande = $demande;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Votre demande a été refusée')
                    ->view('emails.demande-declined');
    }
}
