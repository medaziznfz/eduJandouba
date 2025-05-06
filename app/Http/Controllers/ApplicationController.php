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
            $q->where('status', (int)$currentStatus);
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

        $application->update([
            'etab_confirmed' => true,
            'status'         => 0,
        ]);

        return back()->with('success','Demande acceptée.');
    }

    public function reject(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        $application->update([
            'etab_confirmed' => false,
            'status'         => 2,
        ]);

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
