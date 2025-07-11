<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Formation;
use App\Models\Etablissement;
use App\Models\Grade;
use App\Models\ApplicationRequest;
use Illuminate\Support\Facades\DB;

class UnivDashController extends Controller
{
    public function index()
    {
        // Basic statistics
        $userCount = User::count();
        $formationCount = Formation::count();
        $etablissementCount = Etablissement::count();
        $gradeCount = Grade::count();
        
        // Get demandes where etab_confirmed = true and status = 0
        $demandesCount = ApplicationRequest::where('etab_confirmed', true)
            ->where('status', 0)
            ->count();

        // Formations count per grade (using the pivot table)
        $formationsPerGrade = DB::table('formation_grade')
            ->select(
                'grades.id as grade_id',
                'grades.nom as grade_name',
                DB::raw('count(*) as total')
            )
            ->join('grades', 'formation_grade.grade_id', '=', 'grades.id')
            ->groupBy('grades.id', 'grades.nom')
            ->get();

        // Users by establishment
        $usersPerEtab = User::select('etablissement_id', DB::raw('count(*) as total'))
            ->groupBy('etablissement_id')
            ->with('etablissement')
            ->get();

        // Get pending applications with their relationships
        $pendingApplications = ApplicationRequest::with([
                'formation', 
                'user', 
                'formation.etablissement',
                'user.grade',
                'formation.grades' // Load the grades through the pivot table
            ])
            ->where('etab_confirmed', true)
            ->where('status', 0)
            ->get();

        return view('univ.dashboard', compact(
            'userCount',
            'formationCount',
            'etablissementCount',
            'gradeCount',
            'demandesCount',
            'formationsPerGrade',
            'usersPerEtab',
            'pendingApplications'
        ));
    }
}