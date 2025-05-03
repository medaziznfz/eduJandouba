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
            ->orderBy('updated_at','desc')
            ->paginate(12);

        return view('user.formations.index', compact('formations'));
    }

    public function show(Formation $formation)
    {
        $user = Auth::user();

        // Security: only allow if grade matches (you already have this)
        if ($user->grade_id && ! $formation->grades->contains('id', $user->grade_id)) {
            abort(403);
        }

        // Pull the pivot row (if any)
        $pivot = $formation
            ->applicants()
            ->where('user_id', $user->id)
            ->first()?->pivot;

        $alreadyRequested = (bool) $pivot;
        // default to 0 if pivot is null
        $requestStatus    = $pivot->status ?? 0;

        // Human‐readable labels
        $statusLabels = [
            0 => 'En attente',
            1 => 'Acceptée',
            2 => 'Refusée',
            3 => 'Liste d’attente',
        ];

        return view('user.formations.show', compact(
            'formation',
            'alreadyRequested',
            'requestStatus',
            'statusLabels'
        ));
    }



    public function request(Formation $formation)
    {
        $user = Auth::user();

        if ($formation->applicants()->where('user_id', $user->id)->exists()) {
            return back()->with('info','Vous avez déjà fait une demande.');
        }

        $formation->applicants()->attach($user->id);
        $formation->increment('nbre_demandeur');

        return redirect()
        ->route('user.formations.show', ['formation' => $formation, 'tab' => 'inscrire'])
        ->with('success', 'Votre demande a bien été enregistrée et est en attente de validation.');
    }

}
