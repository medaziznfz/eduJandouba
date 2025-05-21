<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Show Grades & Etablissements management.
     */
    public function index()
    {
        $grades        = Grade::all();
        $etablissements = Etablissement::all();

        return view('univ.settings.index', compact('grades','etablissements'));
    }

    // ----- GRADES -----

    public function storeGrade(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Grade::create($data);

        return back()->with('success', 'Grade ajouté.');
    }

    public function updateGrade(Request $request, Grade $grade)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $grade->update($data);

        return back()->with('success', 'Grade mis à jour.');
    }

    public function destroyGrade(Grade $grade)
    {
        $grade->delete();
        return back()->with('success', 'Grade supprimé.');
    }

    // ----- ETABLISSEMENTS -----

    public function storeEtablissement(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Etablissement::create($data);

        return back()->with('success', 'Établissement ajouté.');
    }

    public function updateEtablissement(Request $request, Etablissement $etablissement)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $etablissement->update($data);

        return back()->with('success', 'Établissement mis à jour.');
    }

    public function destroyEtablissement(Etablissement $etablissement)
    {
        $etablissement->delete();
        return back()->with('success', 'Établissement supprimé.');
    }
}
