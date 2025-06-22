<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Formation;
use App\Models\Etablissement;
use App\Models\Grade;
use App\Models\Demande;
use App\Models\ApplicationRequest;
use Illuminate\Support\Facades\DB;

class UnivDashController extends Controller
{
    public function index()
    {
        // Basic statistics - count only users with role 'user'
        $userCount = User::where('role', 'user')->count();
        $formationCount = Formation::count();
        $etablissementCount = Etablissement::count();
        $gradeCount = Grade::count();
        
        // Get ALL demandes (without status filter)
        $demandesCount = Demande::count();

        // Formations count per grade (using the pivot table)
        $formationsPerGrade = Grade::select(
                'grades.id as grade_id',
                'grades.nom as grade_name',
                DB::raw('COUNT(formation_grade.formation_id) as total')
            )
            ->leftJoin('formation_grade', 'grades.id', '=', 'formation_grade.grade_id')
            ->groupBy('grades.id', 'grades.nom')
            ->get();

        // Users by establishment - only users with role 'user'
        $usersPerEtab = Etablissement::select(
                'etablissements.id',
                'etablissements.nom as etablissement_name',
                DB::raw('COUNT(users.id) as total')
            )
            ->leftJoin('users', function($join) {
                $join->on('etablissements.id', '=', 'users.etablissement_id')
                    ->whereNotNull('users.etablissement_id')
                    ->where('users.role', 'user'); // Added role filter
            })
            ->groupBy('etablissements.id', 'etablissements.nom')
            ->get();

        // Get pending formation applications (this remains filtered)
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

        // Monthly demandes (ALL statuses) and users data (only role 'user')
        $monthlyDemandes = DB::table('demandes')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $monthlyUsers = DB::table('users')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('role', 'user')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Fill in missing months
        $monthlyStats = collect(range(1, 12))->map(function ($month) use ($monthlyDemandes, $monthlyUsers) {
            return [
                'month' => $month,
                'demandes_count' => $monthlyDemandes->has($month) ? $monthlyDemandes[$month]->count : 0,
                'users_count' => $monthlyUsers->has($month) ? $monthlyUsers[$month]->count : 0
            ];
        });

        $userRolesStats = User::select('role', DB::raw('COUNT(*) as total'))
        ->groupBy('role')
        ->get()
        ->keyBy('role');


        return view('univ.dashboard', compact(
            'userCount',
            'formationCount',
            'etablissementCount',
            'gradeCount',
            'demandesCount',
            'formationsPerGrade',
            'usersPerEtab',
            'pendingApplications',
            'monthlyStats',
            'userRolesStats'
        ));
    }
}