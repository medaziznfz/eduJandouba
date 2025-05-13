<?php

namespace App\Http\Controllers;

use App\Models\ApplicationRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function confirm(ApplicationRequest $application, $hash)
    {
        // Check if the hash matches
        if ($application->hash !== $hash) {
            return view('confirmation')  // Directly return the confirmation view
                ->with('status', 'error')
                ->with('message', 'Lien de confirmation invalide.');
        }

        // If the user has already confirmed
        if ($application->user_confirmed) {
            return view('confirmation')  // Directly return the confirmation view
                ->with('status', 'info')
                ->with('message', 'Vous avez déjà confirmé votre inscription.');
        }

        // Update the application status to confirmed (4)
        $application->update([
            'status' => 4,  // 4 = confirmed
            'user_confirmed' => true,
        ]);

        // Increment nbre_accepted
        $application->formation()->increment('nbre_accepted');

        return view('confirmation')  // Directly return the confirmation view
            ->with('status', 'success')
            ->with('message', 'Votre inscription a été confirmée.');
    }

}
