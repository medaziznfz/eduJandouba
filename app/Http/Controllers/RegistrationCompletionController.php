<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistrationCompletionController extends Controller
{
    /**
     * Affiche le formulaire de complétion d'inscription.
     */
    public function showForm(string $token)
    {
        $demande = Demande::where('confirmation_token', $token)
            ->where('status', Demande::STATUS_WAITING_ACCOUNT)
            ->firstOrFail();

        return view('auth.complete-registration', compact('demande'));
    }

    /**
     * Traite le formulaire et crée l'utilisateur.
     */
    public function submitForm(Request $request, string $token)
    {
        $demande = Demande::where('confirmation_token', $token)
            ->where('status', Demande::STATUS_WAITING_ACCOUNT)
            ->firstOrFail();

        $data = $request->validate([
            'telephone'              => 'required|string|unique:users,telephone',
            'password'               => 'required|string|min:8|confirmed',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'prenom'           => $demande->prenom,
            'nom'              => $demande->nom,
            'email'            => $demande->email,
            'cin'              => $demande->cin,
            'telephone'        => $data['telephone'],
            'password'         => Hash::make($data['password']),
            'role'             => 'user',
            'etablissement_id' => $demande->etablissement_id,
        ]);

        // On passe la demande au statut "account_created"
        $demande->update(['status' => Demande::STATUS_CREATED]);

        // On connecte directement l'utilisateur
        Auth::login($user);

        return redirect()->route('user.dashboard')
                         ->with('success', 'Votre compte a été créé avec succès.');
    }
}
