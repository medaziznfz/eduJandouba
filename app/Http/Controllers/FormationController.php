<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    /**
     * Display a paginated list of formations
     * GET /univ/formations
     */
    public function index()
    {
        $formations = Formation::with('grades')
            ->where('etablissement_id', Auth::user()->etablissement_id)
            ->paginate(10);

        return view('formations.index', compact('formations'));
    }

    /**
     * Show the form to create a new formation
     * GET /univ/formations/create
     */
    public function create()
    {
        $grades = Grade::all();
        return view('formations.create', compact('grades'));
    }

    /**
     * Store a newly created formation in storage
     * POST /univ/formations
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'titre'       => 'required|string|max:255',
        'thumbnail'   => 'nullable|image',
        'description' => 'nullable|string',
        'summary'     => 'nullable|string',
        'duree'       => 'required|string|max:255',
        'lieu'        => 'required|string|max:255',
        'capacite'    => 'required|integer|min:1',
        'sessions'    => 'required|in:1,2,3',
        'deadline'    => 'required|date',
        'start_at'    => 'nullable|date',  // ← add validation for start_at
        'mode'        => 'required|in:presentielle,a_distance',
        'link'        => 'nullable|url',
        'grades'      => 'required|array|min:1',
        'grades.*'    => 'exists:grades,id',
    ]);

    if ($request->hasFile('thumbnail')) {
        $data['thumbnail'] = $request->file('thumbnail')->store('formations', 'public');
    }

    $data['etablissement_id'] = Auth::user()->etablissement_id;
    $data['status']           = 'available';
    $data['nbre_demandeur']   = 0;
    $data['nbre_inscrit']     = 0;
    $data['nbre_accepted']    = 0;

    $formation = Formation::create($data);
    $formation->grades()->sync($data['grades']);

    return redirect()
        ->route('univ.formations.index')
        ->with('success', 'Formation créée.');
}


public function update(Request $request, Formation $formation)
{
    $data = $request->validate([
        'titre'       => 'required|string|max:255',
        'thumbnail'   => 'nullable|image',
        'description' => 'nullable|string',
        'summary'     => 'nullable|string',
        'duree'       => 'required|string|max:255',
        'lieu'        => 'required|string|max:255',
        'capacite'    => 'required|integer|min:1',
        'sessions'    => 'required|in:1,2,3',
        'deadline'    => 'required|date',
        'start_at'    => 'nullable|date',  // ← add validation for start_at
        'mode'        => 'required|in:presentielle,a_distance',
        'link'        => 'nullable|url',
        'grades'      => 'required|array|min:1',
        'grades.*'    => 'exists:grades,id',
    ]);

    if ($request->hasFile('thumbnail')) {
        $data['thumbnail'] = $request->file('thumbnail')->store('formations', 'public');
    }

    $formation->update($data);
    $formation->grades()->sync($data['grades']);

    return redirect()
        ->route('univ.formations.index')
        ->with('success', 'Formation mise à jour.');
}



    /**
     * Display the specified formation
     * GET /univ/formations/{formation}
     */
    public function show(Formation $formation)
    {
        return view('formations.show', compact('formation'));
    }

    /**
     * Show the form for editing the specified formation
     * GET /univ/formations/{formation}/edit
     */
    public function edit(Formation $formation)
    {
        $grades = Grade::all();
        return view('formations.edit', compact('formation','grades'));
    }

    /**
     * Update the specified formation in storage
     * PUT/PATCH /univ/formations/{formation}
     */
    

    /**
     * Remove the specified formation from storage
     * DELETE /univ/formations/{formation}
     */
    public function destroy(Formation $formation)
    {
        $formation->delete();
        return response()->json(['success' => true]);
    }
}
