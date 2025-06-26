<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formation en ligne</title>
</head>
<body>
    <h2>Bonjour,</h2>

    <p>La formation <strong>{{ $formation->titre }}</strong> a commencé.</p>

    @if($formation->link)
        <p>Vous pouvez rejoindre la session en ligne via ce lien :</p>
        <p><a href="{{ $formation->link }}">{{ $formation->link }}</a></p>
    @else
        <p>Aucun lien de session fourni.</p>
    @endif

    <p>Bonne formation !</p>
</body>
</html>
