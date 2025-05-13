<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formation Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            color: white;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Confirmation de votre Inscription</h1>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @elseif(session('info'))
            <p style="color: orange;">{{ session('info') }}</p>
        @elseif(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <p>Vous avez demandé à confirmer votre inscription à la formation <strong>{{ $formation->titre }}</strong>.</p>

        @if(session('error'))
            <p>Le lien de confirmation est invalide. Veuillez vérifier votre email et réessayer.</p>
        @elseif(session('info'))
            <p>Vous avez déjà confirmé votre inscription.</p>
        @else
            <p>Votre demande a été confirmée avec succès.</p>
        @endif

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('user.formations.index') }}" class="btn btn-success">Retour à mes formations</a>
        </div>
    </div>

</body>
</html>
