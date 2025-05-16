<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Etablissement;
use App\Models\Grade;

class RequestController extends Controller
{
    public function create()
    {
        $etablissements = Etablissement::all();
        $grades = Grade::all();
        return view('request', compact('etablissements', 'grades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cin' => 'required|digits:8|unique:demandes,cin',
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:demandes,email',
            'etablissement_id' => 'required|exists:etablissements,id',
            'grade_id' => 'required|exists:grades,id',
        ], [
            'cin.unique' => 'Ce numéro CIN est déjà utilisé.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
        ]);

            $etablissementId = $request['etablissement_id'];

            $title        = 'Nouvelle demande reçue';
            $subtitle     = "Demande d'inscription: {$request['prenom']} {$request['nom']} (CIN : {$request['cin']})";
            $redirectLink = route('etab.requests.index'); // ou l'URL que tu veux

            notifyEtab($etablissementId, $title, $subtitle, $redirectLink);

        Demande::create($request->all());

        return redirect('/request')->with('success', 'Votre demande a été envoyée avec succès.');
    }

    public function showStatusForm()
{
    return view('request-status');
}

    public function checkStatus(Request $request)
    {
        $request->validate([
            'cin' => 'required|digits:8',
            'email' => 'required|email',
        ]);

        $demande = Demande::where('cin', $request->cin)
                        ->where('email', $request->email)
                        ->first();

        if ($demande) {
            return view('request-status', [
                'status' => $demande->status,
                'demande' => $demande
            ]);
        }

        return redirect()->route('request.status.form')->withErrors([
            'cin' => 'Aucune demande trouvée avec ce CIN et cette adresse email.',
        ]);
    }

}
