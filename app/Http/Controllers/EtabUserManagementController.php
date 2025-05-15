<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Etablissement;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EtabUserManagementController extends Controller
{
    // Show the list of users for 'etab' role (filter by etablissement_id)
    public function index(Request $request)
    {
        // Get the authenticated 'etab' user
        $etabUser = Auth::user();

        // Get users that belong to the same etablissement as the logged-in user
        $etabUsers = User::with(['etablissement'])
                        ->where('role', 'user') // Only show 'user' role
                        ->where('etablissement_id', $etabUser->etablissement_id) // Filter by the same etablissement_id
                        ->when($request->search, function ($query) use ($request) {
                            return $query->where('prenom', 'like', '%' . $request->search . '%')
                                         ->orWhere('nom', 'like', '%' . $request->search . '%')
                                         ->orWhere('email', 'like', '%' . $request->search . '%');
                        })
                        ->paginate(10); // Add pagination

        return view('etab.users.index', compact('etabUsers'));
    }

    // Show the form to create a new user
    public function create()
    {
        // Fetch all etablissements and grades (to be displayed in the form)
        $etablissements = Etablissement::all();
        $grades = Grade::all();
        return view('etab.users.create', compact('etablissements', 'grades'));
    }

    // Store a newly created user
    public function store(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'telephone' => 'required|digits:8',
            'grade_id' => 'required|exists:grades,id', // Ensure grade is selected
            'cin' => 'required|string|size:8|unique:users,cin', // Validate CIN as required, string, size of 8, and unique
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Get the authenticated 'etab' user
        $etabUser = Auth::user(); 

        // Create the new user with role set to 'user' and the same etablissement_id as the logged-in user
        $user = User::create([
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'cin' => $validated['cin'], // Store CIN
            'password' => Hash::make($validated['password']),
            'etablissement_id' => $etabUser->etablissement_id, // Set the same etablissement_id
            'role' => 'user', // Fixed role as 'user'
            'grade_id' => $validated['grade_id'],
        ]);

        // Redirect with success message
        return redirect()->route('etab.users.index')->with('success', 'Utilisateur créé avec succès!');
    }

    // Show the form to edit an existing user
    public function edit(User $user)
    {
        // Ensure the user belongs to the same etablissement
        $etabUser = Auth::user();
        if ($user->etablissement_id !== $etabUser->etablissement_id) {
            return redirect()->route('etab.users.index')->with('error', 'Vous ne pouvez pas modifier cet utilisateur.');
        }

        // Fetch all etablissements and grades (to be displayed in the form)
        $etablissements = Etablissement::all();
        $grades = Grade::all();
        return view('etab.users.edit', compact('user', 'etablissements', 'grades'));
    }

    // Update the user's details (restrict changing of role)
    public function update(Request $request, User $user)
    {
        // Ensure the user belongs to the same etablissement
        $etabUser = Auth::user();
        if ($user->etablissement_id !== $etabUser->etablissement_id) {
            return redirect()->route('etab.users.index')->with('error', 'Vous ne pouvez pas modifier un utilisateur d\'un autre établissement.');
        }

        // Validate the form input
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|digits:8',
            'grade_id' => 'required|exists:grades,id', // Grade is required
            'cin' => 'required|string|size:8|unique:users,cin,' . $user->id, // Validate CIN as required, string, size of 8, and unique except for the current user
        ]);

        // Handle password update if provided
        if ($request->password) {
            $validated['password'] = Hash::make($request->password);
        }

        // Update the user with new data (we don't allow changing the role or etablissement_id)
        $user->update($validated);

        // Redirect with success message
        return redirect()->route('etab.users.index')->with('success', 'Utilisateur mis à jour avec succès!');
    }

    // Delete the user
    public function destroy(User $user)
    {
        // Ensure the user is deleting within their own etablissement
        $etabUser = Auth::user();
        if ($user->etablissement_id !== $etabUser->etablissement_id) {
            return redirect()->route('etab.users.index')->with('error', 'Vous ne pouvez pas supprimer un utilisateur d\'un autre établissement.');
        }

        // Delete the user from the database
        $user->delete();

        // Redirect with success message
        return redirect()->route('etab.users.index')->with('success', 'Utilisateur supprimé avec succès!');
    }
}
