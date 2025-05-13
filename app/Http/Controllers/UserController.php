<?php
namespace App\Http\Controllers;

use App\Models\ApplicationRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Method to show the application details and confirm/decline options using application ID and hash
    public function index($applicationId, $hash)
    {
        // Find the application by ID
        $application = ApplicationRequest::find($applicationId);

        // Check if the application exists and the hash matches
        if (!$application || $application->hash !== $hash) {
            // If hash is invalid, show the error message and don't pass $formation
            return view('user.application.confirm')->with('error', 'Il n\'y a aucune demande ici.');
        }

        // Get the formation details if hash is valid
        $formation = $application->formation;

        // Return the view with the application and formation details
        return view('user.application.confirm', compact('formation', 'application'));
    }





    // Handle the confirm action
    public function confirmAction($applicationId, $hash)
    {
        // Find the application by ID
        $application = ApplicationRequest::find($applicationId);

        // Check if the application exists and the hash matches
        if (!$application || $application->hash !== $hash) {
            // Show the "no request" message instead of redirecting to formations
            return view('user.application.confirm')->with('error', 'Aucune demande ici ou lien invalide.');
        }

        // Proceed with confirming the application
        $formation = $application->formation;

        // Check if the user has already confirmed
        if ($application->status == 4) {
            return redirect()->route('user.application.index', ['application' => $application->id, 'hash' => $application->hash])
                ->with('info', 'Vous avez déjà confirmé votre inscription à cette formation.');
        }

        // Update the 'user_confirmed' field to true when the user confirms the application
        $application->update([
            'status' => 4,  // Confirmed
            'user_confirmed' => true, // Set the user_confirmed to true
        ]);

        // Increment the nbre_inscrit field for the formation
        $formation->increment('nbre_inscrit');

        // Redirect back to the confirmation page with a success message
        return redirect()->route('user.application.index', ['application' => $application->id, 'hash' => $application->hash])
            ->with('success', 'Votre inscription a été confirmée.');
    }

    // Handle the decline action
    public function declineAction($applicationId, $hash)
    {
        // Find the application by ID
        $application = ApplicationRequest::find($applicationId);

        // Check if the application exists and the hash matches
        if (!$application || $application->hash !== $hash) {
            // Show the "no request" message instead of redirecting to formations
            return view('user.application.confirm')->with('error', 'Aucune demande ici ou lien invalide.');
        }

        $formation = $application->formation;

        // Decline the application
        $application->update([
            'status' => 2,  // Declined
            'user_confirmed' => false,
        ]);

        // Decrement the accepted count for the formation
        $formation->decrement('nbre_accepted');

        // Redirect back to the confirmation page with a message
        return redirect()->route('user.application.index', ['application' => $application->id, 'hash' => $application->hash])
            ->with('info', 'Votre demande a été refusée.');
    }
}

