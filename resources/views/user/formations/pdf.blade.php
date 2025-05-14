<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attestation - {{ $formation->titre }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            height: 50px;
            margin-bottom: 20px;
        }
        .header h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .details {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 30px;
        }
        .details .column {
            flex: 1;
            min-width: 250px;
        }
        .details h3 {
            margin-bottom: 10px;
            font-size: 20px;
        }
        .details p {
            margin-bottom: 5px;
        }
        .qr-code {
            text-align: center;
            margin: 30px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 50px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Attestation de Formation</h2>
            <p><strong>Titre de la formation:</strong> {{ $formation->titre }}</p>
            <p><strong>Formateur:</strong> {{ $formation->formateur_name }} ({{ $formation->formateur_email }})</p>
            <p><strong>Date de début:</strong> {{ \Carbon\Carbon::parse($formation->start_at)->format('d M, Y') }}</p>
            <p><strong>Lieu:</strong> {{ $formation->lieu }}</p>
        </div>

        <div class="details">
            <!-- User Details Column -->
            <div class="column">
                <h3>Détails de l'utilisateur</h3>
                <p><strong>Nom de l'utilisateur:</strong> {{ $user->prenom }} {{ $user->nom }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>CIN:</strong> {{ $user->cin }}</p>
                <p><strong>Téléphone:</strong> {{ $user->telephone }}</p>
            </div>
        </div>

        <div class="qr-code">
            <h3>QR Code de l'attestation</h3>
            <img src="{{ $qrCodeImage }}" alt="QR Code" style="max-width: 200px;">
        </div>

        <div class="footer">
            <p>Cette attestation est générée automatiquement et contient un QR code valide pour validation.</p>
        </div>
    </div>
</body>
</html>
