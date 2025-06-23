@extends('layouts.app')

@push('styles')
<style>
    .certificate-card {
        border: 1px solid #dee2e6;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 2rem;
        background-color: #fff;
    }

    .section-title {
        border-bottom: 2px solid #0d6efd;
        padding-bottom: 5px;
        margin-bottom: 1rem;
        font-weight: bold;
        font-size: 1.2rem;
        color: #0d6efd;
    }

    .info-item {
        margin-bottom: 10px;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
    }

    .info-value {
        color: #212529;
    }

    .not-found {
        background-color: #f8d7da;
        color: #842029;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #f5c2c7;
    }

    .btn-back {
        margin-top: 2rem;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Détails du certificat</h1>

    @if($certificate)
    <div class="certificate-card mx-auto" style="max-width: 900px;">

        {{-- Section Participant --}}
        <div class="section-title">Informations du participant</div>
        <div class="row">
            <div class="col-md-6 info-item">
                <span class="info-label">Nom complet :</span>
                <span class="info-value"> {{ $certificate->user->prenom }} {{ $certificate->user->nom }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Email :</span>
                <span class="info-value"> {{ $certificate->user->email }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">CIN :</span>
                <span class="info-value"> {{ $certificate->user->cin }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Téléphone :</span>
                <span class="info-value"> {{ $certificate->user->telephone }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Établissement :</span>
                <span class="info-value"> {{ $certificate->user->etablissement->nom ?? 'N/A' }}</span>
            </div>
        </div>

        {{-- Section Formation --}}
        <div class="section-title mt-4">Détails de la formation</div>
        <div class="row">
            <div class="col-md-6 info-item">
                <span class="info-label">Titre :</span>
                <span class="info-value"> {{ $certificate->formation->titre }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Description :</span>
                <span class="info-value"> {{ $certificate->formation->description }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Durée :</span>
                <span class="info-value"> {{ $certificate->formation->duree }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Lieu :</span>
                <span class="info-value"> {{ $certificate->formation->lieu }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Date de début :</span>
                <span class="info-value"> {{ $certificate->formation->start_at->format('Y-m-d H:i') }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Date limite :</span>
                <span class="info-value"> {{ $certificate->formation->deadline->format('Y-m-d') }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Sessions :</span>
                <span class="info-value"> {{ $certificate->formation->sessions }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Formateur :</span>
                <span class="info-value">
                    {{ $certificate->formation->formateur->prenom ?? '' }} {{ $certificate->formation->formateur->nom ?? '' }} ({{ $certificate->formation->formateur->email ?? '' }})
                </span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Organisé par :</span>
                <span class="info-value"> {{ $certificate->formation->etablissement->nom ?? 'N/A' }}</span>
            </div>
            <div class="col-md-6 info-item">
                <span class="info-label">Statut :</span>
                <span class="info-value"> {{ $certificate->formation->status_label }}</span>
            </div>
        </div>


        <div class="text-center btn-back">
            <a href="{{ route('qrscanner.scan') }}" class="btn btn-primary">
                Scanner un autre code QR
            </a>
        </div>
    </div>
    @else
    <div class="not-found text-center">
        <h4>Certificat introuvable</h4>
        <p>Aucune correspondance trouvée pour ce code.</p>
        <a href="{{ route('qrscanner.scan') }}" class="btn btn-outline-primary mt-3">Retour au scanner</a>
    </div>
    @endif
</div>
@endsection
