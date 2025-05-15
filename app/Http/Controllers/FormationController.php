<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;  // Make sure to import the Log facade
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class FormationController extends Controller
{
     use AuthorizesRequests;
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
        'start_at'    => 'nullable|date',
        'mode'        => 'required|in:presentielle,a_distance',
        'link'        => 'nullable|url',
        'grades'      => 'required|array|min:1',
        'grades.*'    => 'exists:grades,id',
    ]);

    if ($request->hasFile('thumbnail')) {
        // Storing the file in the 'formations' folder in 'public' disk
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

    public function launch(Formation $formation, Request $request)
    {
        Log::info('Launch method triggered');

        // Validate form data for formateur name, email, and meet link
        $validatedData = $request->validate([
            'formateur_name' => 'required|string|max:255',
            'formateur_email' => 'required|email|max:255',
            'link' => 'nullable|url', // Link for meeting if applicable
        ]);

        // Log the incoming data for debugging purposes
        Log::info('Launching formation with data: ', $validatedData);

        // Update the formation with the formateur details and change status to 'in_progress'
        $formation->formateur_name = $validatedData['formateur_name'];
        $formation->formateur_email = $validatedData['formateur_email'];
        $formation->link = $validatedData['link'] ?? $formation->link; // Update the meet link if provided
        $formation->status = 'in_progress';  // Change status to 'in_progress'

        // Save the changes to the database
        $formation->save();

        // Optionally, you could log the formation's change of status
        Log::info("Formation {$formation->titre} status updated to in_progress.");

        // Return a success message
        return redirect()->route('univ.formations.show', $formation)
            ->with('success', 'La formation a été lancée avec succès et est maintenant en cours.');
    }



    public function completed(Formation $formation)
    {
        $formation->status = 'completed';  // Change status to completed
        $formation->save();

        return redirect()->route('univ.formations.show', $formation)
            ->with('success', 'La formation a été marquée comme complétée.');
    }







}
