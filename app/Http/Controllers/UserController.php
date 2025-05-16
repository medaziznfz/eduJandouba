<?php
namespace App\Http\Controllers;

use App\Models\ApplicationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return view('user.application.confirm')
            ->with('error', 'Aucune demande ici ou lien invalide.');
    }

    $formation = $application->formation;

    // Check if the user has already confirmed
    if ($application->status == 4) {
        return redirect()
            ->route('user.application.index', [
                'application' => $application->id,
                'hash'        => $application->hash
            ])
            ->with('info', 'Vous avez déjà confirmé votre inscription à cette formation.');
    }

    // Update the 'user_confirmed' field to true and status = 4
    $application->update([
        'status'         => 4,    // Confirmed
        'user_confirmed' => true,
    ]);

    // Increment the nbre_inscrit for the formation
    $formation->increment('nbre_inscrit');

    // Notify all “univ” users
    $user     = $application->user;
    $title    = 'Inscription confirmée par l’utilisateur';
    $subtitle = "L’utilisateur {$user->prenom} {$user->nom} a confirmé son inscription à « {$formation->titre} » via le lien.";
    $redirectLink = route('univ.applications.index');

    Log::info('Notify univ: user confirmed via link', [
        'application_id' => $application->id,
        'user_id'        => $user->id,
    ]);
    notifyUniv($title, $subtitle, $redirectLink);

    // Redirect back to the confirmation page with success message
    return redirect()
        ->route('user.application.index', [
            'application' => $application->id,
            'hash'        => $application->hash
        ])
        ->with('success', 'Votre inscription a été confirmée.');
}

public function declineAction($applicationId, $hash)
{
    // Find the application by ID
    $application = ApplicationRequest::find($applicationId);

    // Check if the application exists and the hash matches
    if (!$application || $application->hash !== $hash) {
        return view('user.application.confirm')
            ->with('error', 'Aucune demande ici ou lien invalide.');
    }

    $formation = $application->formation;

    // Decline the application
    $application->update([
        'status'         => 2,    // Declined
        'user_confirmed' => false,
    ]);

    // Decrement the accepted count for the formation
    $formation->decrement('nbre_accepted');

    // Notify all “univ” users
    $user     = $application->user;
    $title    = 'Inscription refusée par l’utilisateur';
    $subtitle = "L’utilisateur {$user->prenom} {$user->nom} a refusé son inscription à « {$formation->titre} » via le lien.";
    $redirectLink = route('univ.applications.index');

    Log::info('Notify univ: user declined via link', [
        'application_id' => $application->id,
        'user_id'        => $user->id,
    ]);
    notifyUniv($title, $subtitle, $redirectLink);

    // Redirect back to the confirmation page with an info message
    return redirect()
        ->route('user.application.index', [
            'application' => $application->id,
            'hash'        => $application->hash
        ])
        ->with('info', 'Votre demande a été refusée.');
}
}

