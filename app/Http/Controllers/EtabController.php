<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ConfirmationDemandeMail;
use App\Mail\DemandeDeclinedMail;

class EtabController extends Controller
{
    /**
     * Affiche la liste des demandes pour l'établissement connecté,
     * triée selon l'ordre de statut souhaité.
     */
    public function index()
    {
        $demandes = Demande::where('etablissement_id', Auth::user()->etablissement_id)
            ->orderByRaw(
                "FIELD(status, ?, ?, ?, ?)",
                [
                    Demande::STATUS_PROCESSING,
                    Demande::STATUS_WAITING_ACCOUNT,
                    Demande::STATUS_DECLINED,
                    Demande::STATUS_CREATED,
                ]
            )
            ->get();

        return view('etab.requests', compact('demandes'));
    }

    /**
     * Passe la demande d'un statut à l'autre :
     * - request_processing      → waiting_account_creation (envoi mail)
     * - waiting_account_creation → account_declined   (envoi mail de refus)
     */
    public function updateStatus(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);

        // Sécurité : même établissement
        if ($demande->etablissement_id !== Auth::user()->etablissement_id) {
            return response()->json(['success' => false, 'message' => 'Non autorisé.'], 403);
        }

        switch ($demande->status) {
            case Demande::STATUS_PROCESSING:
                // 1ère étape : envoi du mail de complétion
                $demande->status             = Demande::STATUS_WAITING_ACCOUNT;
                $demande->confirmation_token = Str::uuid();
                $demande->save();

                Mail::to($demande->email)
                    ->send(new ConfirmationDemandeMail($demande));

                return response()->json([
                    'success' => true,
                    'message' => 'Email de complétion envoyé et statut mis à jour.'
                ]);

            case Demande::STATUS_WAITING_ACCOUNT:
                // 2ᵉ étape : refus automatique
                $demande->status = Demande::STATUS_DECLINED;
                $demande->save();

                Mail::to($demande->email)
                    ->send(new DemandeDeclinedMail(
                        $demande,
                        'Votre demande a été refusée par le validateur.'
                    ));

                return response()->json([
                    'success' => true,
                    'message' => 'Demande refusée et email de refus envoyé.'
                ]);

            default:
                // autres statuts non modifiables ici
                return response()->json([
                    'success' => false,
                    'message' => 'Statut non modifiable.'
                ], 403);
        }
    }

    /**
     * Même logique que updateStatus, mais pour plusieurs demandes
     * (uniquement passage request_processing → waiting_account_creation).
     */
    public function batchUpdate(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        $ids = $request->input('ids');

        $demandes = Demande::whereIn('id', $ids)
            ->where('etablissement_id', Auth::user()->etablissement_id)
            ->where('status', Demande::STATUS_PROCESSING)
            ->get();

        foreach ($demandes as $demande) {
            $demande->status             = Demande::STATUS_WAITING_ACCOUNT;
            $demande->confirmation_token = Str::uuid();
            $demande->save();

            Mail::to($demande->email)
                ->send(new ConfirmationDemandeMail($demande));
        }

        return response()->json(['success' => true]);
    }

    /**
     * Refuser une demande (avec motif libre).
     */
    public function decline(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        $demande = Demande::findOrFail($id);

        if (
            $demande->etablissement_id !== Auth::user()->etablissement_id ||
            $demande->status !== Demande::STATUS_PROCESSING
        ) {
            return response()->json(['success' => false, 'message' => 'Action non autorisée.'], 403);
        }

        $demande->status = Demande::STATUS_DECLINED;
        $demande->save();

        Mail::to($demande->email)
            ->send(new DemandeDeclinedMail($demande, $request->reason));

        return response()->json([
            'success' => true,
            'message' => 'Demande refusée et email envoyé.'
        ]);
    }

    /**
     * Supprimer une seule demande.
     */
    public function destroy(Demande $demande)
    {
        if ($demande->etablissement_id !== Auth::user()->etablissement_id) {
            abort(403, 'Non autorisé.');
        }

        $demande->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Supprimer plusieurs demandes.
     */
    public function batchDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        $ids = $request->input('ids');

        Demande::whereIn('id', $ids)
            ->where('etablissement_id', Auth::user()->etablissement_id)
            ->delete();

        return response()->json(['success' => true]);
    }
}
