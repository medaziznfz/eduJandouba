{{-- resources/views/confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .alert {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 18px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="alert alert-{{ session('status') == 'success' ? 'success' : (session('status') == 'error' ? 'danger' : 'info') }}">
        <h2>{{ session('status') == 'success' ? 'Confirmation réussie !' : (session('status') == 'error' ? 'Erreur' : 'Information') }}</h2>
        <p>{{ session('message') }}</p>
        <a href="{{ route('user.formations.index') }}" style="text-decoration: none; color: #fff; background-color: #007bff; padding: 10px 20px; border-radius: 5px;">
            Retour à mes formations
        </a>
    </div>
</body>
</html>
