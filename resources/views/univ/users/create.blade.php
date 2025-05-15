@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Ajouter un Utilisateur</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('univ.users.store') }}" method="POST">
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
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Numéro de téléphone</label>
                        <input type="text" class="form-control" name="telephone" required>
                    </div>
                    <div class="mb-3">
                        <label for="cin" class="form-label">CIN</label>
                        <input type="text" class="form-control" name="cin" required>
                    </div>
                    <div class="mb-3">
                        <label for="etablissement_id" class="form-label">Établissement</label>
                        <select class="form-control" name="etablissement_id">
                            <option value="">Aucun</option>
                            @foreach($etablissements as $etablissement)
                                <option value="{{ $etablissement->id }}">{{ $etablissement->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="grade_id" class="form-label">Grade</label>
                        <select class="form-control" name="grade_id">
                            <option value="">Aucun</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select class="form-control" name="role" required>
                            <option value="user">Utilisateur</option>
                            <option value="etab">Établissement</option>
                            <option value="univ">Université</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter l'Utilisateur</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
