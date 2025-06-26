@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Modifier un Formateur</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('univ.formateurs.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="nom" value="{{ old('nom', $user->nom) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="telephone" class="form-label">Numéro de téléphone</label>
                        <input type="text" class="form-control" name="telephone" value="{{ old('telephone', $user->telephone) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="cin" class="form-label">CIN</label>
                        <input type="text" class="form-control" name="cin" value="{{ old('cin', $user->cin) }}" required>
                    </div>

                    <!-- Role (readonly as info) -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select class="form-control" name="role" disabled>
                            <option value="forma" selected>Formateur</option>
                        </select>
                    </div>

                    <!-- Password (optional) -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password">
                        <small class="text-muted">Laissez vide si vous ne voulez pas modifier le mot de passe.</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour le Formateur</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
