<?php
namespace App\Mail;

use App\Models\Formation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormationLaunched extends Mailable
{
    use Queueable, SerializesModels;

    public $formation;

    public function __construct(Formation $formation)
    {
        $this->formation = $formation;
    }

    public function build()
    {
        return $this->subject('Votre formation a commencé')
                    ->view('emails.formation-launched');
    }
}
