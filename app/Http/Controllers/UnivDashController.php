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
        $formationsPerGrade = Grade::select(
                'grades.id as grade_id',
                'grades.nom as grade_name',
                DB::raw('COUNT(formation_grade.formation_id) as total')
            )
            ->leftJoin('formation_grade', 'grades.id', '=', 'formation_grade.grade_id')
            ->groupBy('grades.id', 'grades.nom')
            ->get();

        // Users by establishment (ignore users with null etablissement_id)
        $usersPerEtab = Etablissement::select(
        'etablissements.id',
        'etablissements.nom as etablissement_name',
        DB::raw('COUNT(users.id) as total')
            )
            ->leftJoin('users', function($join) {
                $join->on('etablissements.id', '=', 'users.etablissement_id')
                    ->whereNotNull('users.etablissement_id'); // filtrer ici
            })
            ->groupBy('etablissements.id', 'etablissements.nom')
            ->get();


        // Get pending applications with relationships
        $pendingApplications = ApplicationRequest::with([
                'formation', 
                'user', 
                'formation.etablissement',
                'user.grade',
                'formation.grades'
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
