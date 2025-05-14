<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
</head>
<body>

    <h1>Generated QR Code</h1>

    {{-- Display the QR code --}}
    @if(isset($qrCodeImage))
        <img src="{{ $qrCodeImage }}" alt="QR Code" />
    @else
        <p>No QR code available for this request.</p>
    @endif

</body>
</html>
