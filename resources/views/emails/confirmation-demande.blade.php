<h2>Bonjour {{ $demande->prenom }},</h2>

<p>Votre demande a été validée. Veuillez compléter vos informations pour finaliser votre inscription :</p>

<p>
    <a href="{{ url('/complete-registration/' . $demande->confirmation_token) }}">
        Cliquez ici pour compléter votre inscription
    </a>
</p>

<p>Merci,<br>L’équipe JANDOUBA University</p>
