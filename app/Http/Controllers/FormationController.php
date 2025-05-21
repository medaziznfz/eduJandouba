<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class FormationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a paginated list of formations.
     */
    public function index()
    {
        $formations = Formation::with('grades')
            ->where('etablissement_id', Auth::user()->etablissement_id)
            ->paginate(10);

        return view('formations.index', compact('formations'));
    }

    /**
     * Show the form to create a new formation.
     */
    public function create()
    {
        $grades     = Grade::all();
        $formateurs = User::where('role', 'forma')->get();

        return view('formations.create', compact('grades', 'formateurs'));
    }

    /**
     * Store a newly created formation in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'         => 'required|string|max:255',
            'thumbnail'     => 'nullable|image',
            'description'   => 'nullable|string',
            'summary'       => 'nullable|string',
            'duree'         => 'required|string|max:255',
            'lieu'          => 'required|string|max:255',
            'capacite'      => 'required|integer|min:1',
            'sessions'      => 'required|in:1,2,3',
            'deadline'      => 'required|date|after_or_equal:today',
            'start_at'      => 'required|date|after_or_equal:deadline',
            'mode'          => 'required|in:presentielle,a_distance',
            'link'          => 'nullable|url',
            'grades'        => 'required|array|min:1',
            'grades.*'      => 'exists:grades,id',
            'formateur_id'  => 'required|exists:users,id',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                                       ->store('formations', 'public');
        }

        // Set fixed fields
        $data['etablissement_id'] = Auth::user()->etablissement_id;
        $data['nbre_demandeur']   = 0;
        $data['nbre_inscrit']     = 0;
        $data['nbre_accepted']    = 0;

        // Auto‐compute status: if start_at ≤ today → in_progress, else available
        $startAt = Carbon::parse($data['start_at']);
        $data['status'] = $startAt->lte(Carbon::today())
            ? 'in_progress'
            : 'available';

        // Create & sync grades
        $formation = Formation::create($data);
        $formation->grades()->sync($data['grades']);

        return redirect()
            ->route('univ.formations.index')
            ->with('success', 'Formation créée.');
    }

    /**
     * Show the form to edit an existing formation.
     */
    public function edit(Formation $formation)
    {
        $grades     = Grade::all();
        $formateurs = User::where('role', 'forma')->get();

        return view('formations.edit', compact('formation', 'grades', 'formateurs'));
    }

    /**
     * Update the specified formation in storage.
     */
    public function update(Request $request, Formation $formation)
    {
        $data = $request->validate([
            'titre'         => 'required|string|max:255',
            'thumbnail'     => 'nullable|image',
            'description'   => 'nullable|string',
            'summary'       => 'nullable|string',
            'duree'         => 'required|string|max:255',
            'lieu'          => 'required|string|max:255',
            'capacite'      => 'required|integer|min:1',
            'sessions'      => 'required|in:1,2,3',
            'deadline'      => 'required|date|after_or_equal:today',
            'start_at'      => 'required|date|after_or_equal:deadline',
            'mode'          => 'required|in:presentielle,a_distance',
            'link'          => 'nullable|url',
            'grades'        => 'required|array|min:1',
            'grades.*'      => 'exists:grades,id',
            'formateur_id'  => 'required|exists:users,id',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                                       ->store('formations', 'public');
        }

        // Update core fields
        $formation->update($data);
        $formation->grades()->sync($data['grades']);

        // Recompute status if start_at crosses today boundary
        $startAt = Carbon::parse($formation->start_at);

        if ($formation->status === 'available' && $startAt->lte(Carbon::today())) {
            $formation->status = 'in_progress';
            $formation->save();
        }
        elseif ($formation->status === 'in_progress' && $startAt->gt(Carbon::today())) {
            $formation->status = 'available';
            $formation->save();
        }

        return redirect()
            ->route('univ.formations.index')
            ->with('success', 'Formation mise à jour.');
    }

    /**
     * Display the specified formation.
     */
    public function show(Formation $formation)
    {
        return view('formations.show', compact('formation'));
    }

    /**
     * Remove the specified formation.
     */
    public function destroy(Formation $formation)
    {
        $formation->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Launch (start) a formation manually.
     */
    public function launch(Formation $formation, Request $request)
    {
        Log::info("Launching formation #{$formation->id}");

        $data = $request->validate([
            'link' => 'nullable|url',
        ]);

        if (isset($data['link'])) {
            $formation->link = $data['link'];
        }

        $formation->status = 'in_progress';
        $formation->save();

        return redirect()
            ->route('univ.formations.show', $formation)
            ->with('success', 'La formation est maintenant en cours.');
    }

    /**
     * Mark the formation as completed.
     */
    public function completed(Formation $formation)
    {
        $formation->status = 'completed';
        $formation->save();

        return redirect()
            ->route('univ.formations.show', $formation)
            ->with('success', 'La formation a été marquée comme complétée.');
    }
}
