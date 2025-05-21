{{-- resources/views/formations/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="row mb-3 position-relative" style="z-index:2;">
        <div class="col text-end">
            @if($formation->status !== 'completed')
                <a href="{{ route('univ.formations.edit', $formation) }}" class="btn btn-sm btn-warning me-2">
                    <i class="ri-pencil-line align-bottom"></i> Éditer
                </a>
            @endif
            <a href="{{ route('univ.formations.index') }}" class="btn btn-sm btn-secondary">
                <i class="ri-arrow-go-back-line align-bottom"></i> Retour
            </a>
        </div>
    </div>

    {{-- En-tête + Onglets --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-n4 mx-n4">
                <div class="bg-warning-subtle">
                    <div class="card-body pb-0 px-4">
                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-auto">
                                        <div class="avatar-md">
                                            <div class="avatar-title bg-white rounded-circle">
                                                @if($formation->thumbnail)
                                                    <img src="{{ asset('storage/' . $formation->thumbnail) }}"
                                                         alt="Vignette"
                                                         class="avatar-xs rounded-circle"
                                                         style="object-fit: cover; width:100%; height:100%;">
                                                @else
                                                    <i class="ri-image-2-line fs-32 text-secondary"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <h4 class="fw-bold">{{ $formation->titre }}</h4>
                                        <div class="hstack gap-3 flex-wrap">
                                            <div>
                                                <i class="ri-building-line align-bottom me-1"></i>
                                                {{ optional($formation->etablissement)->nom ?? 'Indépendant' }}
                                            </div>
                                            <div class="vr"></div>
                                            <div>
                                                Date création :
                                                <span class="fw-medium">
                                                    {{ $formation->created_at->format('d M, Y') }}
                                                </span>
                                            </div>
                                            <div class="vr"></div>
                                            <div>
                                                Date limite :
                                                <span class="fw-medium">
                                                    {{ $formation->deadline->format('d M, Y') }}
                                                </span>
                                            </div>
                                            <div class="vr"></div>
                                            <div>
                                                Date de début :
                                                <span class="fw-medium">
                                                    {{ $formation->start_at
                                                        ? $formation->start_at->format('d M, Y')
                                                        : 'Non défini' }}
                                                </span>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="badge rounded-pill
                                                bg-{{ $formation->status == 'available'
                                                    ? 'success'
                                                    : ($formation->status == 'in_progress'
                                                        ? 'warning'
                                                        : 'primary') }}
                                                fs-12">
                                                {{ ucfirst(str_replace('_',' ',$formation->status)) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-auto">
                                <div class="hstack gap-1 flex-wrap">
                                    <button type="button" class="btn py-0 fs-16 favourite-btn active">
                                        <i class="ri-star-fill"></i>
                                    </button>
                                    <button type="button" class="btn py-0 fs-16 text-body">
                                        <i class="ri-share-line"></i>
                                    </button>
                                    <button type="button" class="btn py-0 fs-16 text-body">
                                        <i class="ri-flag-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active fw-semibold"
                                   data-bs-toggle="tab"
                                   href="#tab-details"
                                   role="tab">
                                    Détails
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold"
                                   data-bs-toggle="tab"
                                   href="#tab-launch"
                                   role="tab">
                                    Lancer formation
                                </a>
                            </li>
                        </ul>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

    {{-- Contenu des onglets --}}
    <div class="row">
        <div class="col-12">
            <div class="tab-content mt-4">

                {{-- Onglet Détails --}}
                <div class="tab-pane fade show active" id="tab-details" role="tabpanel">
                    <div class="row gx-4">
                        <div class="col-xl-9 col-lg-8">
                            {{-- Résumé --}}
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-uppercase mb-3">Résumé</h6>
                                    <div class="text-body">
                                        {!! $formation->summary !!}
                                    </div>
                                </div>
                            </div>

                            {{-- Informations --}}
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-uppercase mb-3">Informations</h6>
                                    <dl class="row mb-0">
                                        <dt class="col-sm-3 text-muted">Description</dt>
                                        <dd class="col-sm-9">{{ $formation->description }}</dd>

                                        <dt class="col-sm-3 text-muted">Durée</dt>
                                        <dd class="col-sm-9">{{ $formation->duree }}</dd>

                                        <dt class="col-sm-3 text-muted">Lieu</dt>
                                        <dd class="col-sm-9">{{ $formation->lieu }}</dd>

                                        <dt class="col-sm-3 text-muted">Capacité</dt>
                                        <dd class="col-sm-9">{{ $formation->capacite }}</dd>

                                        <dt class="col-sm-3 text-muted">Sessions</dt>
                                        <dd class="col-sm-9">{{ $formation->sessions }}</dd>

                                        <dt class="col-sm-3 text-muted">Grades</dt>
                                        <dd class="col-sm-9">
                                            {{ $formation->grades->pluck('nom')->join(', ') }}
                                        </dd>

                                        {{-- Nouveau champ Formateur --}}
                                        <dt class="col-sm-3 text-muted">Formateur</dt>
                                        <dd class="col-sm-9">
                                            {{ $formation->formateur->prenom }}
                                            {{ $formation->formateur->nom }}
                                            ({{ $formation->formateur->email }})
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        {{-- Colonne latérale --}}
                        <div class="col-xl-3 col-lg-4">
                            {{-- Statistiques --}}
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-uppercase mb-3">Statistiques</h6>
                                    <p class="mb-2">
                                        <i class="ri-list-check align-bottom me-1"></i>
                                        Demandes : <span class="fw-medium">{{ $formation->nbre_demandeur }}</span>
                                    </p>
                                    <p class="mb-2">
                                        <i class="ri-user-2-line align-bottom me-1"></i>
                                        Inscrits : <span class="fw-medium">{{ $formation->nbre_inscrit }}</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Progression --}}
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-uppercase mb-3">Progression</h6>
                                    @php
                                        $pct = $formation->capacite
                                            ? round($formation->nbre_inscrit * 100 / $formation->capacite)
                                            : 0;
                                    @endphp
                                    <div class="progress mb-2" style="height:6px;">
                                        <div class="progress-bar bg-success"
                                             role="progressbar"
                                             style="width: {{ $pct }}%;"
                                             aria-valuenow="{{ $pct }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        {{ $pct }}% des places remplies
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->
                </div><!-- end tab-details -->

                {{-- Onglet Lancer formation --}}
                <div class="tab-pane fade" id="tab-launch" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="fw-semibold text-uppercase mb-3">Démarrer la Formation</h6>

                            @if($formation->status == 'available')
                                {{-- Formulaire de lancement --}}
                                <form action="{{ route('univ.formations.launch', $formation) }}" method="POST" id="launch-form">
                                    @csrf


                                    @if($formation->mode == 'a_distance')
                                        <div class="mb-4">
                                            <label for="link" class="form-label">Lien de la rencontre</label>
                                            <input type="url" id="link" class="form-control" value="{{ old('link', $formation->link) }}" name="link" required>
                                        </div>
                                    @endif

                                    {{-- Launch Button --}}
                                    <button type="submit" class="btn btn-success btn-lg mb-5" id="launch-btn">
                                        <i class="ri-play-line align-bottom"></i> Lancer la formation
                                    </button>
                                </form>

                                {{-- Display list of users (Confirmed, Not Confirmed, and Waiting) in the same line --}}
                                <div class="container mb-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <h6 class="fw-semibold text-uppercase mb-3">Utilisateurs Confirmés</h6>
                                            <ul class="list-group">
                                                @foreach($formation->applicants as $user)
                                                    @if($user->pivot->user_confirmed)
                                                        <li class="list-group-item list-group-item-primary">
                                                            {{ $user->cin }} - {{ $user->prenom }} {{ $user->nom }} 
                                                            ({{ optional($user->etablissement)->nom }})
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="col-12 col-sm-4">
                                            <h6 class="fw-semibold text-uppercase mb-3">Utilisateurs Non Confirmés</h6>
                                            <ul class="list-group">
                                                @foreach($formation->applicants as $user)
                                                    @if($user->pivot->status == 1 && !$user->pivot->user_confirmed)  {{-- Show only accepted users --}}
                                                        <li class="list-group-item list-group-item-secondary">
                                                            {{ $user->cin }} - {{ $user->prenom }} {{ $user->nom }} 
                                                            ({{ optional($user->etablissement)->nom }})
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="col-12 col-sm-4">
                                            <h6 class="fw-semibold text-uppercase mb-3">Liste d'Attente</h6>
                                            <ul class="list-group">
                                                @foreach($formation->applicants as $user)
                                                    @if($user->pivot->status == 3)
                                                        <li class="list-group-item list-group-item-warning">
                                                            {{ $user->cin }} - {{ $user->prenom }} {{ $user->nom }} 
                                                            ({{ optional($user->etablissement)->nom }})
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @elseif($formation->status == 'in_progress')
                                {{-- Show details of formateur and users list when in progress --}}
                                <div class="mb-4">
                                    @if($formation->mode == 'a_distance')
                                        <p><strong>Lien de la rencontre:</strong> <a href="{{ $formation->link }}" target="_blank">{{ $formation->link }}</a></p>
                                    @endif
                                </div>

                                {{-- Show all users when in progress --}}
                                <div class="container mb-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <h6 class="fw-semibold text-uppercase mb-3">Utilisateurs Confirmés</h6>
                                            <ul class="list-group">
                                                @foreach($formation->applicants as $user)
                                                    @if($user->pivot->user_confirmed)
                                                        <li class="list-group-item list-group-item-primary">
                                                            {{ $user->cin }} - {{ $user->prenom }} {{ $user->nom }} 
                                                            ({{ optional($user->etablissement)->nom }})
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="col-12 col-sm-4">
                                            <h6 class="fw-semibold text-uppercase mb-3">Utilisateurs Non Confirmés</h6>
                                            <ul class="list-group">
                                                @foreach($formation->applicants as $user)
                                                    @if($user->pivot->status == 1 && !$user->pivot->user_confirmed)  {{-- Show only accepted users --}}
                                                        <li class="list-group-item list-group-item-secondary">
                                                            {{ $user->cin }} - {{ $user->prenom }} {{ $user->nom }} 
                                                            ({{ optional($user->etablissement)->nom }})
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="col-12 col-sm-4">
                                            <h6 class="fw-semibold text-uppercase mb-3">Liste d'Attente</h6>
                                            <ul class="list-group">
                                                @foreach($formation->applicants as $user)
                                                    @if($user->pivot->status == 3)
                                                        <li class="list-group-item list-group-item-warning">
                                                            {{ $user->cin }} - {{ $user->prenom }} {{ $user->nom }} 
                                                            ({{ optional($user->etablissement)->nom }})
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- Button to mark the formation as completed --}}
                                <form action="{{ route('univ.formations.completed', $formation) }}" method="POST" class="mt-4">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg mb-5">
                                        <i class="ri-check-line align-bottom"></i> Formation Complétée
                                    </button>
                                </form>
                            @elseif($formation->status == 'completed')
                                {{-- Show details of formateur and users list but no "Formation Complétée" button --}}
                                <div class="mb-4">
                                    <p><strong>Formation Complétée</strong></p>
                                    @if($formation->mode == 'a_distance')
                                        <p><strong>Lien de la rencontre:</strong> <a href="{{ $formation->link }}" target="_blank">{{ $formation->link }}</a></p>
                                    @endif
                                </div>

                                {{-- Show only confirmed users when completed --}}
                                <h6 class="fw-semibold text-uppercase mb-3">Utilisateurs Confirmés</h6>
                                <ul class="list-group">
                                    @foreach($formation->applicants as $user)
                                        @if($user->pivot->user_confirmed)
                                            <li class="list-group-item list-group-item-primary m-1">
                                                {{ $user->cin }} - {{ $user->prenom }} {{ $user->nom }} 
                                                ({{ optional($user->etablissement)->nom }})
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div><!-- end tab-pane -->

            </div><!-- end tab-content -->
        </div><!-- end col -->
    </div><!-- end row -->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('launch-btn');
            if (!btn) return;

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const cap   = {{ $formation->capacite }};
                const conf  = {{ $formation->nbre_inscrit }};
                const f     = @json($formation->formateur->only('prenom','nom','email'));
                const meet  = document.getElementById('link')?.value || '';

                let html = `
                    <p><strong>Capacité :</strong> ${cap}</p>
                    <p><strong>Confirmés :</strong> ${conf}</p>
                    <p><strong>Formateur :</strong> ${f.prenom} ${f.nom} (${f.email})</p>
                `;
                if (meet) {
                    html += `<p><strong>Lien :</strong> <a href="${meet}" target="_blank">${meet}</a></p>`;
                }

                Swal.fire({
                    title: 'Confirmer le lancement',
                    html: html,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, lancer',
                    cancelButtonText: 'Annuler'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById('launch-form').submit();
                    }
                });
            });
        });
    </script>
@endpush
