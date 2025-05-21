{{-- resources/views/user/formations/show.blade.php --}}
@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;
    // today at 00:00
    $today = Carbon::today();
    // has the deadline *date* already passed?
    $pastDeadline = $formation->deadline->lt($today);
    // disable inscription if past deadline AND user hasn't already requested
    $disableInscrire = $pastDeadline && ! $alreadyRequested;
@endphp


<div class="container-fluid py-4">
    {{-- Boutons S’inscrire / Retour --}}
    <div class="row mb-3 position-relative" style="z-index:2;">
        <div class="col text-end">
            <button
                id="inscrire-action-btn"
                class="btn btn-sm btn-success me-2"
                {{ in_array($formation->status, ['completed','canceled']) || $disableInscrire ? 'disabled' : '' }}>
                <i class="ri-pencil-fill align-bottom"></i> S’inscrire
            </button>
            <a href="{{ route('user.formations.index') }}" class="btn btn-sm btn-secondary">
                <i class="ri-arrow-go-back-line align-bottom"></i> Retour
            </a>
        </div>
    </div>

    {{-- En-tête + onglets --}}
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
                                                    <img src="{{ asset('storage/'.$formation->thumbnail) }}"
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
                                                <span class="fw-medium">{{ $formation->created_at->format('d M, Y') }}</span>
                                            </div>
                                            <div class="vr"></div>
                                            <div>
                                                Date limite :
                                                <span class="fw-medium">{{ $formation->deadline->format('d M, Y') }}</span>
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

                        {{-- Tabs --}}
                        <ul class="nav nav-tabs-custom border-bottom-0 px-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active fw-semibold"
                                   data-bs-toggle="tab"
                                   href="#tab-details"
                                   role="tab">
                                    Détails
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    id="inscrire-tab-btn"
                                    class="nav-link fw-semibold {{ $disableInscrire || !in_array($formation->status, ['available','in_progress']) ? 'disabled text-muted' : '' }}"
                                    href="#tab-inscrire"
                                    role="tab"
                                    @if(!in_array($formation->status, ['available','in_progress']) || $disableInscrire)
                                        aria-disabled="true" tabindex="-1"
                                    @else
                                        data-bs-toggle="tab"
                                    @endif>
                                    S’inscrire
                                </a>
                            </li>
                            @if(in_array($formation->status, ['available','in_progress']) && $requestStatus === 4)
                                <li class="nav-item">
                                    <a class="nav-link fw-semibold"
                                       data-bs-toggle="tab"
                                       href="#tab-attestation"
                                       role="tab">
                                        Attestation
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
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
                                                <a href="{{ $formation->link }}" target="_blank">{{ $formation->link }}</a>
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

                                        {{-- Formateur --}}
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
                </div>
                {{-- end tab-details --}}

                {{-- Onglet S’inscrire --}}
                <div class="tab-pane fade" id="tab-inscrire" role="tabpanel">
                    <div class="card text-center">
                        <div class="card-body py-5">
                            @if($formation->status !== 'available' && $formation->status !== 'in_progress' || $disableInscrire)
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
                                    <button class="btn btn-secondary btn-sm mb-2" disabled>
                                        Demande déjà envoyée
                                    </button>
                                    <div>
                                        <small>
                                            Status actuel :
                                            <span class="badge bg-info fs-6 px-3 py-1">
                                                {{ $statusLabels[$requestStatus] }}
                                            </span>
                                        </small>
                                    </div>

                                    @if($requestStatus == 1)
                                        <form method="POST" action="{{ route('user.formations.confirm_or_reject', $formation) }}">
                                            @csrf
                                            <button type="submit" name="action" value="confirm" class="btn btn-success btn-sm mb-3">
                                                Confirmer
                                            </button>
                                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm mb-3">
                                                Refuser
                                            </button>
                                        </form>
                                    @endif

                                    @if($requestStatus == 4)
                                        <p class="text-success">Votre demande a été confirmée.</p>
                                    @elseif($requestStatus == 2)
                                        <p class="text-danger">Votre demande a été rejetée.</p>
                                    @endif
                                @else
                                    <form id="inscription-form" method="POST"
                                          action="{{ route('user.formations.request', $formation) }}">
                                        @csrf
                                        <button id="inscription-btn"
                                                class="btn btn-primary btn-sm mb-5">
                                            <i class="ri-pencil-fill align-bottom"></i> S’inscrire
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Attestation tab... --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.feather) feather.replace();

        // Top “S’inscrire” button → onglet inscription
        document.getElementById('inscrire-action-btn')?.addEventListener('click', () => {
            document.getElementById('inscrire-tab-btn')?.click();
        });

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

        // Preserve tab on flash
        const params = new URLSearchParams(window.location.search);
        if (params.get('tab') === 'inscrire') {
            document.getElementById('inscrire-tab-btn')?.click();
        }
    });
</script>
@endpush
