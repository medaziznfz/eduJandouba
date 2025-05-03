@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Boutons S’inscrire / Retour --}}
    <div class="row mb-3 position-relative" style="z-index:2;">
        <div class="col text-end">
            <button
                id="inscrire-action-btn"
                class="btn btn-sm btn-success me-2"
                {{ $formation->status !== 'available' ? 'disabled' : '' }}>
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
                        {{-- Vignette --}}
                        <div class="avatar-md me-3">
                            <div class="avatar-title bg-white rounded-circle">
                                @if($formation->thumbnail)
                                    <img src="{{ asset('storage/'.$formation->thumbnail) }}"
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
                                <div><i class="ri-building-line align-bottom me-1"></i>
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

                    {{-- Onglets --}}
                    <ul class="nav nav-tabs-custom border-bottom-0 px-4" role="tablist">
                        <li class="nav-item">
                            <a id="details-tab-btn" class="nav-link active fw-semibold"
                               data-bs-toggle="tab" href="#tab-details" role="tab">
                                Détails
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                              id="inscrire-tab-btn"
                              class="nav-link fw-semibold {{ $formation->status !== 'available' ? 'disabled text-muted' : '' }}"
                              {{ $formation->status === 'available' ? 'data-bs-toggle=tab' : '' }}
                              href="#tab-inscrire"
                              role="tab">
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
                        <div class="col-xl-9 col-lg-8">
                            {{-- Résumé --}}
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-uppercase mb-3">Résumé</h6>
                                    {!! $formation->summary !!}
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

                        {{-- Statistiques & progression --}}
                        <div class="col-xl-3 col-lg-4">
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
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-uppercase mb-3">Progression</h6>
                                    @php
                                        $pct = $formation->capacite
                                            ? round(100 * $formation->nbre_inscrit / $formation->capacite)
                                            : 0;
                                    @endphp
                                    <div class="progress mb-2" style="height:6px;">
                                        <div class="progress-bar bg-success"
                                             style="width: {{ $pct }}%;"></div>
                                    </div>
                                    <small class="text-muted">{{ $pct }}% des places remplies</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end tab-details -->

                {{-- Onglet S’inscrire --}}
                <div class="tab-pane fade" id="tab-inscrire" role="tabpanel">
                    <div class="card text-center">
                        <div class="card-body py-5">
                            @if($formation->status !== 'available')
                                <i class="ri-lock-line fs-48 text-secondary mb-3"></i>
                                <h5 class="mb-1">Inscriptions fermées</h5>
                                <p class="text-muted">Vous ne pouvez plus vous inscrire à cette formation.</p>
                            @else
                                <i class="ri-user-add-line fs-48 text-primary mb-3"></i>
                                <h5 class="mb-1">Inscription à la formation</h5>
                                <p class="text-muted mb-4">
                                    Cliquez ci-dessous pour faire votre demande d’inscription.
                                </p>

                                @if($alreadyRequested)
                                    <button class="btn btn-secondary btn-lg mb-2" disabled>
                                        Demande déjà envoyée
                                    </button>
                                    <div>
                                        <small>Status actuel :
                                            <span class="badge bg-info fs-6 px-3 py-1">
                                                {{ $statusLabels[$requestStatus] ?? $statusLabels[0] }}
                                            </span>
                                        </small>
                                    </div>
                                @else
                                    <form id="inscription-form" method="POST"
                                          action="{{ route('user.formations.request', $formation) }}">
                                        @csrf
                                        <button id="inscription-btn"
                                                class="btn btn-primary btn-lg mb-5">
                                            <i class="ri-pencil-fill align-bottom"></i> S’inscrire
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div><!-- end tab-inscrire -->

            </div><!-- end tab-content -->
        </div>
    </div><!-- end row -->
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.feather) feather.replace();

        // Top “S’inscrire” bouton → onglet inscription
        document.getElementById('inscrire-action-btn')?.addEventListener('click', () => {
            if ("{{ $formation->status }}" === 'available') {
                document.getElementById('inscrire-tab-btn').click();
            }
        });

        // ?tab=inscrire auto-open
        const params = new URLSearchParams(window.location.search);
        if (params.get('tab') === 'inscrire') {
            document.getElementById('inscrire-tab-btn').click();
        }

        // Confirmation SweetAlert avant submit
        const form = document.getElementById('inscription-form');
        form?.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
                title: 'Confirmer votre demande',
                text: "Voulez-vous vraiment vous inscrire ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Oui, confirmer',
                cancelButtonText: 'Annuler'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });

        // Afficher les flash via SweetAlert, et rester sur l’onglet inscription
        @if(session('success'))
            Swal.fire({ icon:'success', title:'Succès', text:"{{ session('success') }}", didClose() {
                document.getElementById('inscrire-tab-btn').click();
            }});
        @endif
        @if(session('error'))
            Swal.fire({ icon:'error', title:'Erreur', text:"{{ session('error') }}", didClose() {
                document.getElementById('inscrire-tab-btn').click();
            }});
        @endif
        @if(session('info'))
            Swal.fire({ icon:'info', title:'Info', text:"{{ session('info') }}", didClose() {
                document.getElementById('inscrire-tab-btn').click();
            }});
        @endif
    });
    </script>
@endpush
