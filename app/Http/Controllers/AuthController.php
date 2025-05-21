<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifiant' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->identifiant)
                    ->orWhere('cin', $request->identifiant)
                    ->orWhere('telephone', $request->identifiant)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $remember = $request->filled('remember');
            Auth::login($user, $remember);

            // Redirection selon rôle (utilise les nouveaux noms courts)
            return match ($user->role) {
                'forma' => redirect()->route('forma.dashboard'),
                'etab' => redirect()->route('etab.dashboard'),
                'univ' => redirect()->route('univ.dashboard'),
                'user' => redirect()->route('user.dashboard'),
                default => redirect()->route('login')->withErrors([
                    'identifiant' => 'Rôle non reconnu.'
                ]),
            };
        }

        return back()->withErrors([
            'identifiant' => 'Identifiant ou mot de passe incorrect.'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
