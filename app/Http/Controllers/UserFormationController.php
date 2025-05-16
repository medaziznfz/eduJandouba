<?php
// app/Http/Controllers/UserFormationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Formation;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Log;

class UserFormationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $formations = Formation::with('grades')
            // si l’utilisateur a un grade, on ne prend que ces formations
            ->when($user->grade_id, fn($q) =>
                $q->whereHas('grades', fn($q2) =>
                    $q2->where('id', $user->grade_id)
                )
            )
            ->orderBy('updated_at', 'desc')
            ->paginate(12);

        return view('user.formations.index', compact('formations'));
    }

    public function show(Formation $formation)
{
    $user = Auth::user();

    // Security: only allow if grade matches
    if ($user->grade_id && !$formation->grades->contains('id', $user->grade_id)) {
        abort(403);
    }

    // Pull the pivot row (if any), only if the user has requested the formation
    $pivot = $formation->applicants()
        ->where('user_id', $user->id)
        ->first()?->pivot;

    // Check if the user has already requested the formation
    $alreadyRequested = (bool) $pivot;
    $requestStatus = $pivot ? $pivot->status : 0;  // Default to 0 if pivot is null

    // Human-readable labels for the request statuses
    $statusLabels = [
        0 => 'En attente',
        1 => 'Acceptée',
        2 => 'Refusée',
        3 => 'Liste d’attente',
        4 => 'Confirmée',  // Added for Confirmed status
    ];

    // Ensure that requestStatus is a valid key in statusLabels
    if (!array_key_exists($requestStatus, $statusLabels)) {
        $requestStatus = 0; // Default to 'En attente' if the status is invalid
    }

    // Get user details for the Attestation tab
    $userDetails = [
        'name' => $user->prenom . ' ' . $user->nom,
        'email' => $user->email,
        'cin' => $user->cin,
        'telephone' => $user->telephone,
        'etablissement' => $user->etablissement->nom ?? 'Non défini',
        'grade' => $user->grade->nom ?? 'Non défini',
    ];

    // Get the hash value from the pivot table
    $hash = $pivot ? $pivot->hash : null;

    // Generate QR Code for the hash (use the hash field from the pivot table)
    if (is_null($hash)) {
        $hash = 'default_hash_value'; // Set a default value if hash is null
    }

    $qrCode = new QrCode($hash);  // Generate QR code based on the hash
    $writer = new PngWriter();
    $qrCodeData = $writer->write($qrCode);
    $base64QrCode = base64_encode($qrCodeData->getString());
    $qrCodeImage = 'data:image/png;base64,' . $base64QrCode;

    // Return the view with all data
    return view('user.formations.show', compact(
        'formation',
        'alreadyRequested',
        'requestStatus',
        'statusLabels',
        'pivot', // Pass the pivot to the view, so you can access it
        'qrCodeImage', // Pass the QR code to the view
        'userDetails' // Pass user details to the view
    ));
}

    public function request(Formation $formation)
    {
        $user = Auth::user();

        if ($formation->applicants()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Vous avez déjà fait une demande.');
        }

        $formation->applicants()->attach($user->id);
        $formation->increment('nbre_demandeur');

        // → Maintenant on récupère l’ID de l’établissement depuis l’utilisateur
        $etabId = $user->etablissement_id;

        // En cas d’utilisateur sans établissement configuré : 
        if (! $etabId) {
            Log::warning("Utilisateur {$user->id} sans etablissement_id !");
            // soit on abort(), soit on continue sans notifier
        }

        $title        = 'Nouvelle demande de formation';
        $subtitle     = "L’utilisateur {$user->prenom} {$user->nom} a demandé la formation « {$formation->titre} ».";
        $redirectLink = route('etab.applications.index');

        // Et on notifie vraiment
        notifyEtab($etabId, $title, $subtitle, $redirectLink);

        return redirect()
            ->route('user.formations.show', ['formation' => $formation, 'tab' => 'inscrire'])
            ->with('success', 'Votre demande a bien été enregistrée et est en attente de validation.');
    }

    
    public function confirmOrReject(Formation $formation, Request $request)
    {
        $user = Auth::user();

        // Ensure the user has requested this formation and its status is 'Acceptée'
        $pivot = $formation->applicants()
            ->where('user_id', $user->id)
            ->first()?->pivot;

        if (!$pivot || $pivot->status !== 1) {  // If the status is not 'Acceptée'
            return redirect()->route('user.formations.show', $formation)->with('error', 'Action impossible, statut incorrect.');
        }

        // Determine the action (confirm or reject)
        if ($request->action === 'confirm') {
            // Update the status to 'Confirmed' (4)
            $pivot->update(['status' => 4, 'user_confirmed' => true]);

            // Increment the number of enrolled students
            $formation->increment('nbre_inscrit');
            $message = 'Votre demande a été confirmée.';
        } elseif ($request->action === 'reject') {
            // Update the status to 'Rejected' (2)
            $pivot->update(['status' => 2, 'user_confirmed' => false]);
            $message = 'Votre demande a été rejetée.';
        } else {
            return redirect()->route('user.formations.show', $formation)->with('error', 'Action invalide.');
        }

        return redirect()->route('user.formations.show', $formation)->with('success', $message);
    }

    public function downloadPDF($id)
{
    $formation = Formation::findOrFail($id);
    $user = Auth::user();  // Get the currently authenticated user

    // Check if there's an application request
    $pivot = $formation->applicants()->where('user_id', $user->id)->first()?->pivot;
    if (!$pivot) {
        return redirect()->route('user.formations.show', $formation)->with('error', 'Vous n\'avez pas de demande pour cette formation.');
    }

    // Get the user's application request details
    $hash = $pivot->hash;
    $qrCode = new QrCode($hash);  // Generate QR code based on the hash
    $writer = new PngWriter();
    $qrCodeData = $writer->write($qrCode);
    $base64QrCode = base64_encode($qrCodeData->getString());

    // Create mPDF instance
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'autoLangToFont' => true,
        'autoScriptToLang' => true,
    ]);

    // Prepare the HTML for the PDF
    $html = view('user.formations.pdf', [
        'formation' => $formation,
        'user' => $user,
        'qrCodeImage' => 'data:image/png;base64,' . $base64QrCode,
    ])->render();

    // Write HTML content to the PDF
    $mpdf->WriteHTML($html);

    // Output the PDF as download
    return $mpdf->Output('attestation-' . $formation->id . '.pdf', 'D');
}
}
