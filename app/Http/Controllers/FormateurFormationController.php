<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Formation;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Mail\FormationLaunched;
use Illuminate\Support\Facades\Mail;

class FormateurFormationController extends Controller
{
    public function index()
    {
        $formations = Formation::where('formateur_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(12);

        $statusLabels = [
            'available'   => 'Disponible',
            'in_progress' => 'En cours',
            'completed'   => 'Terminé',
            'canceled'    => 'Annulé',
        ];

        return view('forma.formations.index', compact('formations','statusLabels'));
    }

    public function show(Formation $formation, Request $request)
    {
        abort_if($formation->formateur_id !== Auth::id(), 403);

        // date filter (defaults to today)
        $date = $request->query('date', Carbon::today()->toDateString());

        $users = collect();
        $records = collect();

        if (in_array($formation->status, ['in_progress','completed'])) {
            $users = $formation->applicants()
                ->wherePivot('user_confirmed', true)
                ->get();

            $records = Attendance::where('formation_id', $formation->id)
                ->where('date', $date)
                ->pluck('present','user_id');
        }

        return view('forma.formations.show', compact(
            'formation','date','users','records'
        ));
    }

    public function launch(Formation $formation, Request $request)
    {
        abort_if($formation->formateur_id !== Auth::id(), 403);

        $data = $request->validate(['link' => 'nullable|url']);

        if (!empty($data['link'])) {
            $formation->link = $data['link'];
        }

        $formation->status = 'in_progress';
        $formation->save();

        // ✅ Send email if mode is "a_distance"
        if ($formation->mode === 'a_distance') {
            $confirmedUsers = $formation->applicants()
                ->wherePivot('user_confirmed', true)
                ->get();

            foreach ($confirmedUsers as $user) {
                Mail::to($user->email)->send(new FormationLaunched($formation));
            }
        }

        return redirect()
            ->route('forma.formations.show', $formation)
            ->with('success', 'Formation lancée.');
    }


    public function completed(Formation $formation)
    {
        abort_if($formation->formateur_id !== Auth::id(), 403);
        $formation->status = 'completed';
        $formation->save();

        return redirect()
            ->route('forma.formations.show',$formation)
            ->with('success','Formation terminée.');
    }

    public function storePresence(Request $request, Formation $formation)
    {
        abort_if($formation->formateur_id !== Auth::id(), 403);

        $data = $request->validate([
            'date'      => 'required|date',
            'present'   => 'array',
            'present.*' => 'boolean',
        ]);

        $presentIds = array_keys(array_filter($data['present'] ?? []));

        $formation->applicants()
            ->wherePivot('user_confirmed', true)
            ->get()
            ->each(function($user) use($formation,$data,$presentIds) {
                Attendance::updateOrCreate(
                    [
                        'formation_id'=>$formation->id,
                        'user_id'=>$user->id,
                        'date'=>$data['date'],
                    ],
                    [
                        'present'=>in_array($user->id,$presentIds,true),
                    ]
                );
            });

        return redirect()
            ->route('forma.formations.show',[
                'formation'=>$formation,
                'date'=>$data['date']
            ])
            ->with('success','Présence enregistrée pour '.Carbon::parse($data['date'])->format('d/m/Y'));
    }
}
