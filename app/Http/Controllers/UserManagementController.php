<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // Show the list of users
    public function index(Request $request)
    {
        $etabUsers = User::with(['etablissement'])
                        ->where('role', 'etab') // Filter by 'etab' role
                        ->when($request->search, function ($query) use ($request) {
                            return $query->where('prenom', 'like', '%' . $request->search . '%')
                                         ->orWhere('nom', 'like', '%' . $request->search . '%')
                                         ->orWhere('email', 'like', '%' . $request->search . '%');
                        })
                        ->paginate(10); // Add pagination

        $etablissements = Etablissement::all(); // Fetch all etablissements

        return view('univ.users.index', compact('etabUsers', 'etablissements'));
    }

    // Show the form to create a new user
    public function create()
    {
        $etablissements = Etablissement::all();
        return view('univ.users.create', compact('etablissements'));
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
            'etablissement_id' => 'required|exists:etablissements,id', // Make sure it's required
            'cin' => 'required|digits:8|unique:users,cin', // CIN must be 8 digits and unique
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the new user with role set to 'etab'
        $user = User::create([
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'cin' => $validated['cin'],  // Store the CIN
            'password' => Hash::make($validated['password']),
            'etablissement_id' => $validated['etablissement_id'],
            'role' => 'etab', // Fixed role as 'etab'
        ]);

        // Redirect with success message
        return redirect()->route('univ.users.index')->with('success', 'Utilisateur créé avec succès!');
    }

    // Show the form to edit an existing user
    public function edit(User $user)
    {
        $etablissements = Etablissement::all();
        return view('univ.users.edit', compact('user', 'etablissements'));
    }

    // Update the user's details
    public function update(Request $request, User $user)
    {
        // Validate the form input
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|digits:8',
            'etablissement_id' => 'required|exists:etablissements,id', // Make sure it's required during update
            'cin' => 'required|digits:8|unique:users,cin,' . $user->id, // CIN must be 8 digits and unique during update
        ]);

        // Update the user with new data
        $user->update($validated);

        // Redirect with success message
        return redirect()->route('univ.users.index')->with('success', 'Utilisateur mis à jour avec succès!');
    }

    // Delete the user
    public function destroy(User $user)
    {
        // Delete the user from the database
        $user->delete();

        // Redirect with success message
        return redirect()->route('univ.users.index')->with('success', 'Utilisateur supprimé avec succès!');
    }
}
