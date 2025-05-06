<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\ApplicationRequest;
use Illuminate\Support\Str;

class UniversityApplicationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $q = ApplicationRequest::with(['formation', 'user'])
            ->where('etab_confirmed', true);

        $tab = $request->get('status', 'all');
        if ($tab !== 'all') {
            $q->where(function($q2) use ($tab) {
                if ($tab == 0) {
                    $q2->where('status', 0)
                       ->where('univ_confirmed', false);
                } elseif ($tab == 1) {
                    $q2->where('univ_confirmed', true);
                } elseif ($tab == 3) {
                    $q2->where('status', 3);
                } else {
                    $q2->where('status', 2);
                }
            });
        }

        $applications = $q->orderBy('created_at', 'desc')
                          ->paginate(25)
                          ->appends(['status' => $tab]);

        $statusLabels = [
            0 => 'En attente',
            1 => 'Acceptée',
            2 => 'Rejetée',
            3 => 'Liste d’attente',
        ];

        return view('univ.applications.index', compact('applications','statusLabels'));
    }

    public function accept(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        // Remember old acceptance state
        $wasAccepted = $application->univ_confirmed && $application->status === 1;

        // Build a deterministic string of core data
        $data = implode('|', [
            $application->id,
            $application->user_id,
            $application->formation_id,
            $application->created_at->toIsoString(),
        ]);

        $application->update([
            'univ_confirmed' => true,
            'status'         => 1,
            'hash'           => hash('sha256', $data),
        ]);

        if (! $wasAccepted) {
            $application->formation()->increment('nbre_inscrit');
        }

        return back()->with('success','Demande acceptée par l’université.');
    }

    public function reject(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        $wasAccepted = $application->univ_confirmed && $application->status === 1;

        $application->update([
            'univ_confirmed' => false,
            'status'         => 2,
            'hash'           => null,
        ]);

        if ($wasAccepted) {
            $application->formation()->decrement('nbre_inscrit');
        }

        return back()->with('error','Demande rejetée par l’université.');
    }

    public function waitlist(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        $wasAccepted = $application->univ_confirmed && $application->status === 1;

        $application->update([
            'univ_confirmed' => false,
            'status'         => 3,
            'hash'           => null,
        ]);

        if ($wasAccepted) {
            $application->formation()->decrement('nbre_inscrit');
        }

        return back()->with('info','Demande mise en liste d’attente.');
    }

    public function destroy(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        // If it was accepted, decrement the counter
        if ($application->univ_confirmed && $application->status === 1) {
            $application->formation()->decrement('nbre_inscrit');
        }

        $application->delete();

        return back()->with('success','Candidature supprimée.');
    }

    public function restore(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        // Si elle était acceptée, décrémente avant de réinitialiser
        $wasAccepted = $application->univ_confirmed && $application->status === 1;
        if ($wasAccepted) {
            $application->formation()->decrement('nbre_inscrit');
        }

        $application->update([
            'univ_confirmed' => false,
            'status'         => 0,
            'hash'           => null,
        ]);

        return back()->with('info','Candidature restaurée en attente.');
    }
}
