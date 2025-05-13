<?php

namespace App\Http\Controllers;

use App\Models\ApplicationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationConfirmation; // <-- Add this line




class UniversityApplicationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a paginated list of applications.
     * GET /univ/applications
     */
    public function index(Request $request)
    {
        $q = ApplicationRequest::with(['formation', 'user'])
            ->where('etab_confirmed', true);

        // Status filtering logic
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
            4 => 'Confirmée',
        ];

        return view('univ.applications.index', compact('applications', 'statusLabels'));
    }

    /**
     * Accept an application request.
     * POST /univ/applications/{application}/accept
     */
    public function accept(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        // Create a unique hash for confirmation
        $data = implode('|', [
            $application->id,
            $application->user_id,
            $application->formation_id,
            $application->created_at->toIsoString(),
        ]);

        $hash = hash('sha256', $data);

        // Update the application status to accepted and store the hash
        $application->update([
            'univ_confirmed' => true,
            'status' => 1,  // 1 = accepted
            'hash' => $hash,
        ]);

        // Send confirmation email to the user with the confirmation link
        Mail::to($application->user->email)->send(new ApplicationConfirmation($application));

        // Increment the accepted counter for the formation
        $application->formation()->increment('nbre_accepted');

        return back()->with('success', 'Demande acceptée, un lien de confirmation a été envoyé à l\'utilisateur.');
    }

    /**
     * Reject an application request.
     * POST /univ/applications/{application}/reject
     */
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
            $application->formation()->decrement('nbre_accepted');
        }

        return back()->with('error', 'Demande rejetée par l’université.');
    }

    /**
     * Place an application on the waitlist.
     * POST /univ/applications/{application}/waitlist
     */
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
            $application->formation()->decrement('nbre_accepted');
        }

        return back()->with('info', 'Demande mise en liste d’attente.');
    }

    /**
     * Delete an application request.
     * DELETE /univ/applications/{application}
     */
    public function destroy(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        // Decrement accepted count if the application was accepted
        if ($application->univ_confirmed && $application->status === 1) {
            $application->formation()->decrement('nbre_accepted');
        }

        // Delete the application
        $application->delete();

        return back()->with('success', 'Candidature supprimée.');
    }

    /**
     * Restore an application request from rejection or waitlist.
     * POST /univ/applications/{application}/restore
     */
    public function restore(ApplicationRequest $application)
    {
        $this->authorize('manage', $application);

        // Decrement accepted count if the application was accepted
        $wasAccepted = $application->univ_confirmed && $application->status === 1;
        if ($wasAccepted) {
            $application->formation()->decrement('nbre_accepted');
        }

        // Restore application
        $application->update([
            'univ_confirmed' => false,
            'status'         => 0,
            'hash'           => null,
        ]);

        return back()->with('info', 'Candidature restaurée en attente.');
    }
}
