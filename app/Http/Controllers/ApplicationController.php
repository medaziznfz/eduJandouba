<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

class ApplicationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $etabId = Auth::user()->etablissement_id;

        $q = ApplicationRequest::with(['formation','user'])
            ->whereHas('user', fn($qu) =>
                $qu->where('etablissement_id', $etabId)
            );

        $currentStatus = $request->get('status', 'all');
        if ($currentStatus !== 'all') {
            $q->where(function($query) use ($currentStatus) {
                if ($currentStatus == 4) {
                    $query->where('status', 4); // Confirmed status
                } else {
                    $query->where('status', (int)$currentStatus);
                }
            });
        }

        $applications = $q->orderBy('created_at','desc')
                          ->paginate(25)
                          ->appends(['status' => $currentStatus]);

        $statusLabels = [
            0 => 'En attente',
            1 => 'Acceptée',
            2 => 'Rejetée',
            3 => 'Liste d\'attente',
        ];

        return view('etab.applications.index', compact(
            'applications',
            'statusLabels',
            'currentStatus'
        ));
    }

    public function accept(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        // 1) On marque la demande comme confirmée par l'établissement
        $application->update([
            'etab_confirmed' => true,
            'status'         => 0,
        ]);

        // 2) On notifie tous les users 'univ'
        $user      = $application->user;
        $etabName  = optional($user->etablissement)->nom ?? '—';

        $title        = 'Nouvelle demande de formation';
        $subtitle     = "L’utilisateur {$user->prenom} {$user->nom} de {$etabName} a demandé la formation « {$application->formation->titre} ».";
        $redirectLink = route('univ.applications.index'); // ajustez vers la bonne route

        notifyUniv($title, $subtitle, $redirectLink);

        // 3) Retour à la page précédente avec un message
        return back()->with('success', 'Demande acceptée.');
    }

    public function reject(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        // 1) Marquer la demande comme rejetée
        $application->update([
            'etab_confirmed' => false,
            'status'         => 2,
        ]);

        // 2) Préparer et envoyer la notification à l’utilisateur
        $userId    = $application->user_id;
        $formation = $application->formation;

        $title    = 'Demande de formation rejetée';
        $subtitle = "Votre demande pour la formation « {$formation->titre} » a été rejetée.";
        // On utilise route() pour générer le lien de redirection
        $redirectLink = route('user.formations.show', ['formation' => $formation->id]);

        notify($userId, $title, $subtitle, $redirectLink);

        // 3) Redirection via la route nommée
        return back()->with('error','Demande rejetée.');
    }


    public function restore(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        $application->update([
            'etab_confirmed' => false,
            'status'         => 0,
        ]);

        return back()->with('info','Demande restaurée en attente.');
    }

    public function destroy(ApplicationRequest $application): RedirectResponse
    {
        $this->authorize('manage', $application);

        $application->delete();

        return back()->with('success', 'Candidature supprimée.');
    }
}
