<?php
// app/Http/Controllers/DetailsSettingsController.php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Etablissement;

class DetailsSettingsController extends Controller
{
    use AuthorizesRequests; // Add this line to use the trait

    // Display the profile settings
    public function index()
    {
        $user = Auth::user();
        $etablissements = Etablissement::all();
        return view('details', compact('user', 'etablissements'));
    }

    // Handle updating profile details
    public function update(Request $request)
    {
        $user = Auth::user();

        // Check if the user is authorized to update the profile
        $this->authorize('updateProfile', User::class);  // Ensure user is authorized

        // Validate the input fields
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|digits:8',
        ]);

        // Update the user's details in the database
        $user->update($validated);

        // Return success message after updating
        return redirect()->route('profile.index')->with('success', 'Profil mis à jour avec succès.');
    }

    // Handle password change
    public function changePassword(Request $request)
{
    $user = Auth::user();

    // Validate password fields
    $validated = $request->validate([
        'old_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed', // Password must be at least 8 characters long
    ]);

    // Check if the old password matches
    if (!Hash::check($validated['old_password'], $user->password)) {
        return redirect()->route('profile.index')->with('error', 'L\'ancien mot de passe est incorrect.');
    }

    // If the old password is correct, update the password
    try {
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('profile.index')->with('success', 'Mot de passe mis à jour avec succès.');
    } catch (\Exception $e) {
        return redirect()->route('profile.index')->with('error', 'Une erreur est survenue lors de la mise à jour du mot de passe.');
    }
}

}

