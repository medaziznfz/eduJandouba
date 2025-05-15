@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Modifier un Utilisateur</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('etab.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Prénom -->
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                    </div>

                    <!-- Nom -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="nom" value="{{ old('nom', $user->nom) }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Numéro de téléphone</label>
                        <input type="text" class="form-control" name="telephone" value="{{ old('telephone', $user->telephone) }}" required>
                    </div>

                    <!-- CIN -->
                    <div class="mb-3">
                        <label for="cin" class="form-label">CIN</label>
                        <input type="text" class="form-control" name="cin" value="{{ old('cin', $user->cin) }}" required>
                    </div>

                    <!-- Etablissement (disabled) -->
                    <div class="mb-3">
                        <label for="etablissement_id" class="form-label">Établissement</label>
                        <select class="form-control" name="etablissement_id" required disabled>
                            <option value="{{ Auth::user()->etablissement_id }}" selected>
                                {{ Auth::user()->etablissement->nom }}
                            </option>
                        </select>
                    </div>

                    <!-- Grade -->
                    <div class="mb-3">
                        <label for="grade_id" class="form-label">Grade</label>
                        <select class="form-control" name="grade_id" required>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}" 
                                    @if($grade->id == old('grade_id', $user->grade_id)) selected @endif>
                                    {{ $grade->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Role (disabled) -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select class="form-control" name="role" required disabled>
                            <option value="user" selected>Utilisateur</option>
                        </select>
                    </div>

                    <!-- Password (optional) -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password">
                        <small class="text-muted">Laissez vide si vous ne voulez pas modifier le mot de passe.</small>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour l'Utilisateur</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
