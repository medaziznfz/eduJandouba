<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationRequest;
use Illuminate\Support\Facades\Auth;

class QRScannerController extends Controller
{
    /**
     * Show the QR scanner page.
     */
    public function scan()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'forma') {
            abort(403, 'Accès refusé');
        }

        return view('qrscanner.scan');
    }

    /**
     * Show the certificate details after scanning.
     */
    public function showCertificate($hash)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'forma') {
            abort(403, 'Accès refusé');
        }

        $certificate = ApplicationRequest::with([
            'user.grade',
            'user.etablissement',
            'formation.etablissement',
            'formation.formateur',
        ])->where('hash', $hash)->firstOrFail();

        return view('qrscanner.certificate_details', compact('certificate'));
    }
}
