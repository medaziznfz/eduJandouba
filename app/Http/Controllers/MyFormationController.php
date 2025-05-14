<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MyFormationController extends Controller
{
    /**
     * Display all formations the user has requested.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch the requested formations that the user has signed up for,
        // including the pivot data (status, user_confirmed, etc.)
        $formations = $user->requestedFormations()
                           ->wherePivot('status', '!=', 0) // Filter out 'pending' requests if needed
                           ->paginate(12);  // Paginate the results

        // Define status labels for better readability
        $statusLabels = [
            0 => 'En attente',
            1 => 'Acceptée',
            2 => 'Refusée',
            3 => 'Liste d’attente',
            4 => 'Confirmée',
        ];

        return view('user.formations.myFormations', compact('formations', 'statusLabels'));
    }
}
