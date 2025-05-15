<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Etablissement;
use App\Models\Grade;  // Import Grade model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // Show the list of users
    public function index(Request $request)
    {
        $users = User::with(['etablissement', 'grade']) // eager load etablissement and grade
                    ->when($request->search, function ($query) use ($request) {
                        return $query->where('prenom', 'like', '%' . $request->search . '%')
                                     ->orWhere('nom', 'like', '%' . $request->search . '%')
                                     ->orWhere('email', 'like', '%' . $request->search . '%');
                    })
                    ->paginate(10); // Add pagination

        $etablissements = Etablissement::all(); // Fetch all etablissements
        $grades = Grade::all(); // Fetch all grades

        return view('univ.users.index', compact('users', 'etablissements', 'grades'));
    }

    // Show the form to create a new user
    public function create()
    {
        $etablissements = Etablissement::all();
        $grades = Grade::all();
        return view('univ.users.create', compact('etablissements', 'grades'));
    }

    // Store a newly created user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'telephone' => 'required|digits:8',
            'password' => 'required|string|min:8|confirmed',
            'etablissement_id' => 'nullable|exists:etablissements,id',
            'grade_id' => 'nullable|exists:grades,id',
            'role' => 'required|string|in:user,etab,univ',  // Ensure the role is valid
        ]);

        $user = User::create([
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'password' => Hash::make($validated['password']),
            'etablissement_id' => $validated['etablissement_id'],
            'grade_id' => $validated['grade_id'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('univ.users.index')->with('success', 'Utilisateur créé avec succès!');
    }

    // Show the form to edit an existing user
    public function edit(User $user)
    {
        $etablissements = Etablissement::all();
        $grades = Grade::all();
        return view('univ.users.edit', compact('user', 'etablissements', 'grades'));
    }

    // Update the user's details
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|digits:8',
            'etablissement_id' => 'nullable|exists:etablissements,id',
            'grade_id' => 'nullable|exists:grades,id',
            'role' => 'required|string|in:user,etab,univ',
        ]);

        $user->update($validated);

        return redirect()->route('univ.users.index')->with('success', 'Utilisateur mis à jour avec succès!');
    }

    // Delete the user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('univ.users.index')->with('success', 'Utilisateur supprimé avec succès!');
    }
}
