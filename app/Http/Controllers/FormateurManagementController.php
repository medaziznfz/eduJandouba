<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FormateurManagementController extends Controller
{
    // Affiche la liste des formateurs
    public function index(Request $request)
    {
        $etabUsers = User::with(['etablissement'])
            ->where('role', 'forma')
            ->when($request->search, function ($query) use ($request) {
                return $query->where('prenom', 'like', '%' . $request->search . '%')
                    ->orWhere('nom', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->paginate(10);

        $etablissements = Etablissement::all();

        return view('univ.formateurs.index', compact('etabUsers', 'etablissements'));
    }

    // Formulaire de création
    public function create()
    {
        $etablissements = Etablissement::all();
        return view('univ.formateurs.create', compact('etablissements'));
    }

    // Enregistrer un nouveau formateur
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom'    => 'required|string|max:255',
            'nom'       => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email',
            'telephone' => 'required|digits:8',
            'cin'       => 'required|digits:8|unique:users,cin',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'prenom'          => $validated['prenom'],
            'nom'             => $validated['nom'],
            'email'           => $validated['email'],
            'telephone'       => $validated['telephone'],
            'cin'             => $validated['cin'],
            'password'        => Hash::make($validated['password']),
            'role'            => 'forma',
            'etablissement_id'=> null, // 👈 Toujours NULL ici
        ]);

        return redirect()->route('univ.formateurs.index')->with('success', 'Formateur créé avec succès.');
    }

    // Formulaire de modification
    public function edit(User $user)
    {
        $etablissements = Etablissement::all();
        return view('univ.formateurs.edit', compact('user', 'etablissements'));
    }

    // Mise à jour du formateur
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'prenom'    => 'required|string|max:255',
            'nom'       => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|digits:8',
            'cin'       => 'required|digits:8|unique:users,cin,' . $user->id,
        ]);

        $user->update(array_merge($validated, [
            'etablissement_id' => null, // 👈 Toujours NULL ici
        ]));

        return redirect()->route('univ.formateurs.index')->with('success', 'Formateur mis à jour avec succès.');
    }

    // Suppression du formateur
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('univ.formateurs.index')->with('success', 'Formateur supprimé avec succès.');
    }
}
