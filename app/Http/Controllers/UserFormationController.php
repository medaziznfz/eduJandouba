<?php
// app/Http/Controllers/UserFormationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Formation;

class UserFormationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $formations = Formation::with('grades')
            // si l’utilisateur a un grade, on ne prend que ces formations
            ->when($user->grade_id, fn($q) =>
                $q->whereHas('grades', fn($q2) =>
                    $q2->where('id', $user->grade_id)
                )
            )
            ->orderBy('updated_at', 'desc')
            ->paginate(12);

        return view('user.formations.index', compact('formations'));
    }

    public function show(Formation $formation)
    {
        $user = Auth::user();

        // Security: only allow if grade matches
        if ($user->grade_id && ! $formation->grades->contains('id', $user->grade_id)) {
            abort(403);
        }

        // Pull the pivot row (if any), only if the user has requested the formation
        $pivot = $formation->applicants()
            ->where('user_id', $user->id)
            ->first()?->pivot;

        // Check if the user has already requested the formation
        $alreadyRequested = (bool) $pivot;
        $requestStatus = $pivot ? $pivot->status : 0;  // Default to 0 if pivot is null

        // Human-readable labels for the request statuses
        $statusLabels = [
            0 => 'En attente',
            1 => 'Acceptée',
            2 => 'Refusée',
            3 => 'Liste d’attente',
            4 => 'Confirmée',  // Added for Confirmed status
        ];

        // Ensure that requestStatus is a valid key in statusLabels
        if (!array_key_exists($requestStatus, $statusLabels)) {
            $requestStatus = 0; // Default to 'En attente' if the status is invalid
        }

        return view('user.formations.show', compact(
            'formation',
            'alreadyRequested',
            'requestStatus',
            'statusLabels',
            'pivot' // Pass the pivot to the view, so you can access it
        ));
    }

    public function request(Formation $formation)
    {
        $user = Auth::user();

        if ($formation->applicants()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Vous avez déjà fait une demande.');
        }

        $formation->applicants()->attach($user->id);
        $formation->increment('nbre_demandeur');

        return redirect()
            ->route('user.formations.show', ['formation' => $formation, 'tab' => 'inscrire'])
            ->with('success', 'Votre demande a bien été enregistrée et est en attente de validation.');
    }

    public function confirmOrReject(Formation $formation, Request $request)
    {
        $user = Auth::user();

        // Ensure the user has requested this formation and its status is 'Acceptée'
        $pivot = $formation->applicants()
            ->where('user_id', $user->id)
            ->first()?->pivot;

        if (!$pivot || $pivot->status !== 1) {  // If the status is not 'Acceptée'
            return redirect()->route('user.formations.show', $formation)->with('error', 'Action impossible, statut incorrect.');
        }

        // Determine the action (confirm or reject)
        if ($request->action === 'confirm') {
            // Update the status to 'Confirmed' (4)
            $pivot->update(['status' => 4, 'user_confirmed' => true]);

            // Increment the number of enrolled students
            $formation->increment('nbre_inscrit');
            $message = 'Votre demande a été confirmée.';
        } elseif ($request->action === 'reject') {
            // Update the status to 'Rejected' (2)
            $pivot->update(['status' => 2, 'user_confirmed' => false]);
            $message = 'Votre demande a été rejetée.';
        } else {
            return redirect()->route('user.formations.show', $formation)->with('error', 'Action invalide.');
        }

        return redirect()->route('user.formations.show', $formation)->with('success', $message);
    }
}
