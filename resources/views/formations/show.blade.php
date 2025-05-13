@extends('layouts.app')

@section('content')

    {{-- Boutons Éditer / Retour placés avant le header --}}
    <div class="row mb-3 position-relative" style="z-index:2;">
        <div class="col text-end">
            <a href="{{ route('univ.formations.edit', $formation) }}" class="btn btn-sm btn-warning me-2">
                <i class="ri-pencil-line align-bottom"></i> Éditer
            </a>
            <a href="{{ route('univ.formations.index') }}" class="btn btn-sm btn-secondary">
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
                        {{-- Image (avatar) ajustée selon template --}}
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
                                <div><i class="ri-building-line align-bottom me-1"></i>{{ optional($formation->etablissement)->nom ?? 'Indépendant' }}</div>
                                <div class="vr"></div>
                                <div>Date création : <span class="fw-medium">{{ $formation->created_at->format('d M, Y') }}</span></div>
                                <div class="vr"></div>
                                <div>Date limite : <span class="fw-medium">{{ $formation->deadline->format('d M, Y') }}</span></div>
                                <div class="vr"></div>
                                {{-- Added Start at field with Carbon parsing --}}
                                <div>Date de début : <span class="fw-medium">{{ $formation->start_at ? \Carbon\Carbon::parse($formation->start_at)->format('d M, Y') : 'Non défini' }}</span></div>
                                <div class="vr"></div>
                                <div class="badge rounded-pill bg-{{ $formation->status=='available'?'success':'warning' }} fs-12">
                                    {{ ucfirst(str_replace('_',' ',$formation->status)) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Onglets --}}
                    <ul class="nav nav-tabs-custom border-bottom-0 px-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#tab-details" role="tab">Détails</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-launch" role="tab">Lancer formation</a>
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

                            {{-- Carte Résumé --}}
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-uppercase mb-3">Résumé</h6>
                                    <div class="text-body">
                                        {!! $formation->summary !!}
                                    </div>
                                </div>
                            </div>

                            {{-- Carte Informations --}}
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
                                        <dd class="col-sm-9">{{ $formation->grades->pluck('nom')->join(', ') }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        {{-- Colonne latérale --}}
                        <div class="col-xl-3 col-lg-4">
                            {{-- Statistiques rapides --}}
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-uppercase mb-3">Statistiques</h6>
                                    <p class="mb-2"><i class="ri-list-check align-bottom me-1"></i> Demandes : <span class="fw-medium">{{ $formation->nbre_demandeur }}</span></p>
                                    <p class="mb-2"><i class="ri-user-2-line align-bottom me-1"></i> Inscrits : <span class="fw-medium">{{ $formation->nbre_inscrit }}</span></p>
                                </div>
                            </div>
                            {{-- Progression --}}
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-uppercase mb-3">Progression</h6>
                                    @php
                                        $pct = $formation->capacite ? round($formation->nbre_inscrit * 100 / $formation->capacite) : 0;
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
                </div><!-- end tab-pane -->

                {{-- Onglet Lancer formation --}}
                <div class="tab-pane fade" id="tab-launch" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="fw-semibold text-uppercase mb-3">Démarrer la Formation</h6>

                            {{-- Display form to enter formateur information --}}
                            <div class="mb-4">
                                <label for="formateur_name" class="form-label">Nom du formateur</label>
                                <input type="text" id="formateur_name" class="form-control" value="{{ old('formateur_name', $formation->formateur_name) }}" name="formateur_name">
                            </div>

                            <div class="mb-4">
                                <label for="formateur_email" class="form-label">Email du formateur</label>
                                <input type="email" id="formateur_email" class="form-control" value="{{ old('formateur_email', $formation->formateur_email) }}" name="formateur_email">
                            </div>

                            {{-- If the mode is "a_distance", show the "Meet Link" field --}}
                            @if($formation->mode == 'a_distance')
                                <div class="mb-4">
                                    <label for="link" class="form-label">Lien de la rencontre</label>
                                    <input type="url" id="link" class="form-control" value="{{ old('link', $formation->link) }}" name="link">
                                </div>
                            @endif

                            {{-- Display a list of accepted users (with CIN and Full Name) --}}
                            <h6 class="fw-semibold text-uppercase mb-3">Utilisateurs acceptés</h6>
                            <ul class="list-group">
                                @foreach($formation->applicants as $user)
                                    <li class="list-group-item 
                                        @if($user->pivot->status == 4) 
                                            bg-success text-white
                                        @elseif($user->pivot->status == 2) 
                                            bg-danger text-white
                                        @else 
                                            bg-light
                                        @endif">
                                        {{ $user->cin }} - {{ $user->prenom }} {{ $user->nom }} 
                                        ({{ $user->pivot->status == 4 ? 'Confirmé' : ($user->pivot->status == 2 ? 'Refusé' : 'En attente') }})
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Display the number of confirmed users --}}
                            <div class="mt-3">
                                <p><strong>{{ $formation->nbre_inscrit }}</strong> utilisateur(s) confirmé(s) pour cette formation.</p>
                            </div>

                            {{-- Show capacity --}}
                            <div class="mt-3">
                                <p><strong>Capacité de la formation:</strong> {{ $formation->capacite }} utilisateurs</p>
                            </div>

                            {{-- Launch Button (only show if there are confirmed users) --}}
                            @if($formation->nbre_inscrit > 0)
                               <form method="POST" id="launch-form" action="{{ route('univ.formations.launch', $formation) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg mb-5" id="launch-btn">
                                        <i class="ri-play-line align-bottom"></i> Lancer la formation
                                    </button>
                                </form>
                            @else
                                <p class="text-muted">La formation ne peut pas être lancée sans utilisateurs confirmés.</p>
                            @endif
                        </div>
                    </div>
                </div><!-- end tab-pane -->

            </div><!-- end tab-content -->
        </div><!-- end col -->
    </div><!-- end row -->
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        feather.replace();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

    // Handle the launch button click event
    document.getElementById('launch-btn')?.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent form submission before confirmation

        const confirmedUsers = {{ $formation->nbre_inscrit }};
        const totalCapacity = {{ $formation->capacite }};
        const formateurName = document.getElementById('formateur_name').value;
        const formateurEmail = document.getElementById('formateur_email').value;
        const meetLink = document.getElementById('link')?.value;

        // SweetAlert confirmation
        Swal.fire({
            title: 'Confirmer le lancement de la formation',
            html: `
                <p><strong>Capacité:</strong> ${totalCapacity}</p>
                <p><strong>Utilisateurs confirmés:</strong> ${confirmedUsers}</p>
                <p><strong>Formateur:</strong> ${formateurName} (<a href="mailto:${formateurEmail}">${formateurEmail}</a>)</p>
                @if($formation->mode == 'a_distance')
                    <p><strong>Lien de la rencontre:</strong> <a href="${meetLink}" target="_blank">${meetLink}</a></p>
                @endif
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Oui, lancer la formation',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Now, submit the form only after confirmation
                document.getElementById('launch-form').submit();
            }
        });
    });
});

</script>
@endpush
