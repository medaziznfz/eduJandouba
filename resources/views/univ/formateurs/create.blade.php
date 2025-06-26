@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Ajouter un Formateur</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('univ.formateurs.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" name="prenom" required>
                    </div>

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="nom" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Email valide requis">
                    </div>

                    <div class="mb-3">
                        <label for="telephone" class="form-label">Numéro de téléphone</label>
                        <input type="text" class="form-control" name="telephone" required pattern="\d{8}" title="Le numéro doit être composé de 8 chiffres">
                    </div>

                    <div class="mb-3">
                        <label for="cin" class="form-label">CIN</label>
                        <input type="text" class="form-control" name="cin" required pattern="\d{8}" title="Le CIN doit être composé de 8 chiffres">
                    </div>

                    <!-- Role (readonly as info) -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select class="form-control" name="role" disabled>
                            <option value="forma" selected>Formateur</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password" required minlength="8" title="Le mot de passe doit contenir au moins 8 caractères">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" name="password_confirmation" required minlength="8">
                    </div>

                    <button type="submit" class="btn btn-primary">Ajouter le Formateur</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
