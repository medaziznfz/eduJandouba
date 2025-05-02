@extends('layouts.app')

@section('content')
    {{-- Boutons S’inscrire / Retour avant le header --}}
    <div class="row mb-3 position-relative" style="z-index:2;">
        <div class="col text-end">
            <button id="inscrire-action-btn" class="btn btn-sm btn-success me-2">
                <i class="ri-pencil-fill align-bottom"></i> S’inscrire
            </button>
            <a href="{{ route('user.formations.index') }}" class="btn btn-sm btn-secondary">
                <i class="ri-arrow-go-back-line align-bottom"></i> Retour
            </a>
        </div>
    </div>

    {{-- En-tête + onglets --}}
    <div class="row">
        <div class="col-12">
            <div class="card mt-n4 mx-n4">
                <div class="bg-warning-subtle">
                    <div class="card-body pb-0 px-4 d-flex align-items-center">
                        {{-- Avatar / vignette --}}
                        <div class="avatar-md me-3">
                            <div class="avatar-title bg-white rounded-circle">
                                @if($formation->thumbnail)
                                    <img src="{{ asset('storage/' . $formation->thumbnail) }}"
                                         alt="Vignette"
                                         class="avatar-xs rounded-circle"
                                         style="object-fit:cover;">
                                @else
                                    <i class="ri-image-2-line fs-32 text-secondary"></i>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">{{ $formation->titre }}</h4>
                            <div class="hstack gap-3 flex-wrap">
                                <div>
                                    <i class="ri-building-line align-bottom me-1"></i>
                                    {{ optional($formation->etablissement)->nom ?? 'Indépendant' }}
                                </div>
                                <div class="vr"></div>
                                <div>Date création :
                                    <span class="fw-medium">{{ $formation->created_at->format('d M, Y') }}</span>
                                </div>
                                <div class="vr"></div>
                                <div>Date limite :
                                    <span class="fw-medium">{{ $formation->deadline->format('d M, Y') }}</span>
                                </div>
                                <div class="vr"></div>
                                <div class="badge rounded-pill {{ $formation->status_class }} fs-12">
                                    {{ $formation->status_label }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Les onglets --}}
                    <ul class="nav nav-tabs-custom border-bottom-0 px-4" role="tablist">
                        <li class="nav-item">
                            <a id="details-tab-btn" class="nav-link active fw-semibold"
                               data-bs-toggle="tab" href="#tab-details" role="tab">
                                Détails
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="inscrire-tab-btn" class="nav-link fw-semibold"
                               data-bs-toggle="tab" href="#tab-inscrire" role="tab">
                                S’inscrire
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!-- end row -->

    {{-- Contenu des onglets --}}
    <div class="row">
        <div class="col-12">
            <div class="tab-content mt-4">

                {{-- Onglet Détails --}}
                <div class="tab-pane fade show active" id="tab-details" role="tabpanel">
                    <div class="row gx-4">

                        {{-- Colonne principale --}}
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

                                        <dt class="col-sm-3 text-muted">Mode</dt>
                                        <dd class="col-sm-9">
                                            {{ $formation->mode === 'a_distance' ? 'À distance' : 'Présentiel' }}
                                        </dd>

                                        @if($formation->mode === 'a_distance' && $formation->link)
                                            <dt class="col-sm-3 text-muted">Lien</dt>
                                            <dd class="col-sm-9">
                                                <a href="{{ $formation->link }}" target="_blank">
                                                    {{ $formation->link }}
                                                </a>
                                            </dd>
                                        @endif

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
                                    </dl>
                                </div>
                            </div>
                        </div>

                        {{-- Colonne latérale --}}
                        <div class="col-xl-3 col-lg-4">
                            {{-- Stats rapides --}}
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
                                    <div class="progress animated-progress mb-2" style="height:6px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             style="width: {{ $pct }}%;"
                                             aria-valuenow="{{ $pct }}"
                                             aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted">{{ $pct }}% des places remplies</small>
                                </div>
                            </div>
                        </div>

                    </div><!-- end row -->
                </div><!-- end tab-details -->

                {{-- Onglet S’inscrire --}}
                <div class="tab-pane fade" id="tab-inscrire" role="tabpanel">
                    <div class="card text-center">
                        <div class="card-body py-5">
                            <i class="ri-user-add-line fs-48 text-primary mb-3"></i>
                            <h5 class="mb-1">Inscription à la formation</h5>
                            <p class="text-muted mb-4">
                                Veuillez cliquer ci-dessous pour vous inscrire à cette formation.
                            </p>
                            <button class="btn btn-primary btn-lg mb-5">
                                <i class="ri-pencil-fill align-bottom"></i> S’inscrire
                            </button>
                        </div>
                    </div>
                </div><!-- end tab-inscrire -->

            </div><!-- end tab-content -->
        </div><!-- end col -->
    </div><!-- end row -->
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1) Feather icons
        if (window.feather) feather.replace();

        // 2) Top “S’inscrire” button → switch to the inscription tab
        document.getElementById('inscrire-action-btn')
            .addEventListener('click', () => {
                document.getElementById('inscrire-tab-btn').click();
            });

        // 3) If URL has ?tab=inscrire, open that tab on page load
        const params = new URLSearchParams(window.location.search);
        if (params.get('tab') === 'inscrire') {
            document.getElementById('inscrire-tab-btn').click();
        }
    });
</script>
@endpush
