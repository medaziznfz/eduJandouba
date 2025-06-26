<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class PasswordResetCodeController extends Controller
{
    /**
     * Étape 1 : Envoi du code avec CIN + email + téléphone
     */
    public function sendCode(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'cin'       => 'required|string',
            'telephone' => 'required|string',
        ]);

        // Recherche utilisateur
        $user = User::where('email', $request->email)
                    ->where('cin', $request->cin)
                    ->where('telephone', $request->telephone)
                    ->first();

        if (!$user) {
            return back()
                ->with('error', 'Aucun utilisateur trouvé avec ces informations.')
                ->withInput();
        }

        // Supprime les anciens codes
        PasswordResetCode::where('email', $user->email)->delete();

        // Génère un code à 4 chiffres
        $code = rand(1000, 9999);

        // Sauvegarde le code
        PasswordResetCode::create([
            'email' => $user->email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Envoi du mail
        Mail::raw("Votre code de réinitialisation est : $code", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Code de réinitialisation du mot de passe');
        });

        // Stocker l'email en session pour l'étape suivante
        session(['password_reset_email' => $user->email]);

        // Redirection vers formulaire vérification code
        return redirect()->route('password.code.form.verify')
                         ->with('success', 'Un code de vérification a été envoyé à votre adresse email.');
    }

    /**
     * Affiche le formulaire de vérification du code
     */
    public function showVerifyCodeForm(Request $request)
    {
        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.code.form')->withErrors(['email' => 'Adresse email requise']);
        }

        return view('auth.verify-reset-code', compact('email'));
    }

    /**
     * Vérifie le code envoyé par l'utilisateur
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'digit1' => 'required|digits:1',
            'digit2' => 'required|digits:1',
            'digit3' => 'required|digits:1',
            'digit4' => 'required|digits:1',
        ]);

        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.code.form')->withErrors(['email' => 'Adresse email requise']);
        }

        $code = $request->digit1 . $request->digit2 . $request->digit3 . $request->digit4;

        $record = PasswordResetCode::where('email', $email)
                    ->where('code', $code)
                    ->where('expires_at', '>', now())
                    ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Code invalide ou expiré'])->withInput();
        }

        // Code valide, suppression du code pour éviter réutilisation
        PasswordResetCode::where('email', $email)->delete();

        // Mettre en session que la réinitialisation est autorisée
        session([
            'password_reset_allowed' => true,
        ]);

        // Redirection vers le formulaire de réinitialisation sans email dans l'URL
        return redirect()->route('password.reset.form');
    }

    /**
     * Affiche le formulaire de réinitialisation du mot de passe
     */
    public function showResetPasswordForm(Request $request)
    {
        if (!session('password_reset_allowed') || !session('password_reset_email')) {
            return redirect()->route('password.code.form')
                ->withErrors(['access' => 'Accès refusé. Veuillez suivre la procédure correcte.']);
        }

        $email = session('password_reset_email');

        return view('auth.reset-password', compact('email'));
    }

    /**
     * Renvoi du code de vérification
     */
    public function resendCode(Request $request)
    {
        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.code.form')->withErrors(['email' => 'Adresse email requise pour renvoyer le code.']);
        }

        // Recherche utilisateur
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.code.form')->withErrors(['email' => 'Utilisateur introuvable.']);
        }

        // Cherche un code valide existant
        $existingCode = PasswordResetCode::where('email', $email)
            ->where('expires_at', '>', now())
            ->first();

        if ($existingCode) {
            $code = $existingCode->code;
        } else {
            PasswordResetCode::where('email', $email)->delete();

            $code = rand(1000, 9999);

            PasswordResetCode::create([
                'email' => $email,
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]);
        }

        Mail::raw("Votre code de réinitialisation est : $code", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Code de réinitialisation du mot de passe');
        });

        return back()->with('success', 'Le code de vérification a été renvoyé à votre adresse email.');
    }

    /**
     * Réinitialise le mot de passe après validation
     */
    public function resetPassword(Request $request)
    {
        // Vérifie que la réinitialisation est autorisée et que l'email est en session
        if (!session('password_reset_allowed') || !session('password_reset_email')) {
            return redirect()->route('password.code.form')
                ->withErrors(['access' => 'Accès refusé. Veuillez suivre la procédure correcte.']);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = session('password_reset_email');

        $user = User::where('email', $email)->firstOrFail();

        $user->password = Hash::make($request->password);
        $user->save();

        // Supprimer tous les codes liés à cet email
        PasswordResetCode::where('email', $email)->delete();

        // Nettoyer la session
        session()->forget(['password_reset_email', 'password_reset_allowed']);

        return redirect()->route('login')->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
    }
}
