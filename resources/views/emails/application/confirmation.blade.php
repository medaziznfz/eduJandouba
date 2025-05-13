<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Candidature</title>
</head>
<body>
    <h1>Bonjour {{ $userName }},</h1>
    <p>Félicitations ! Vous avez été accepté pour la formation "{{ $formationTitle }}".</p>
    <p>Veuillez confirmer votre inscription en cliquant sur le lien ci-dessous :</p>
    <a href="{{ $confirmationUrl }}" style="color: #fff; background-color: #4CAF50; padding: 10px 15px; text-decoration: none; border-radius: 5px;">Confirmer l'inscription</a>
    <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
    <p>Merci,</p>
    <p>L'équipe de l'université</p>
</body>
</html>
