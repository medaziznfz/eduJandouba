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
        // sécurité : si l’utilisateur a un grade, vérifier qu’il y figure
        if ($user->grade_id && ! $formation->grades->contains('id', $user->grade_id)) {
            abort(403);
        }

        return view('user.formations.show', compact('formation'));
    }
}
