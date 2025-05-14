<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

class QRController extends Controller
{
    // Show the QR code creation page (optional)
    public function index()
    {
        return view('qrcode.index');
    }

    // Method to generate the QR code and return it as a base64-encoded image
    public function create()
    {
        // Create a new QR code instance with the content (replace with your dynamic data)
        $qrCode = new QrCode('techsolutionstuff.com'); // You can replace this with dynamic data, e.g., ApplicationRequest hash

        // Set writer options

        // Create the PngWriter and write the QR code to a string (raw binary)
        $writer = new PngWriter();
        $qrCodeData = $writer->write($qrCode);

        // Get the raw binary data from the PngResult and then convert it to base64
        $base64QrCode = base64_encode($qrCodeData->getString());

        // Return the base64-encoded QR code as a Data URI
        $qrCodeImage = 'data:image/png;base64,' . $base64QrCode;

        // Pass the generated QR code to the view
        return view('qrcode.show', compact('qrCodeImage'));
    }
}
