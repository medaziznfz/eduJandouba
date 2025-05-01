@extends('layouts.app')

@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4>Détails de la formation</h4>
      <div>
        <a href="{{ route('univ.formations.edit', $formation) }}" class="btn btn-warning">Éditer</a>
        <a href="{{ route('univ.formations.index') }}" class="btn btn-secondary">Retour</a>
      </div>
    </div>
    <div class="card-body">
      <p><strong>Titre :</strong> {{ $formation->titre }}</p>
      <p><strong>Description :</strong> {{ $formation->description }}</p>
      <p><strong>Durée :</strong> {{ $formation->duree }}</p>
      <p><strong>Lieu :</strong> {{ $formation->lieu }}</p>
      <p><strong>Capacité :</strong> {{ $formation->capacite }}</p>
      <p><strong>Sessions :</strong> {{ $formation->sessions }}</p>
      <p><strong>Date limite :</strong> {{ $formation->deadline->format('d/m/Y') }}</p>
      <p><strong>Grades concernés :</strong>
        {{ $formation->grades->pluck('nom')->join(', ') }}
      </p>
      <p>
        <strong>Statut :</strong>
        <span class="badge {{ $formation->status_class }}">
          {{ $formation->status_label }}
        </span>
      </p>
      <p><strong>Nombre de demandes :</strong> {{ $formation->nbre_demandeur }}</p>
      <p><strong>Nombre d’inscrits :</strong> {{ $formation->nbre_inscrit }}</p>
    </div>
  </div>
@endsection
