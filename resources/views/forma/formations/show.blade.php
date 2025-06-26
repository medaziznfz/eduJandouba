{{-- resources/views/forma/formations/show.blade.php --}}
@extends('layouts.app')

@section('content')
  <div class="row mb-3 position-relative" style="z-index:2;">
    <div class="col text-end">
      <a href="{{ route('forma.formations.index') }}"
         class="btn btn-sm btn-secondary">
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
                          <img src="{{ asset('storage/'.$formation->thumbnail) }}"
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
                      <div>Date de début :
                        <span class="fw-medium">
                          {{ $formation->start_at
                             ? $formation->start_at->format('d M, Y')
                             : 'Non défini' }}
                        </span>
                      </div>
                      <div class="vr"></div>
                      <div class="badge rounded-pill
                           bg-{{ $formation->status=='available'
                             ? 'success'
                             : ($formation->status=='in_progress'
                               ? 'warning'
                               : 'primary')
                           }} fs-12">
                        {{ ucfirst(str_replace('_',' ',$formation->status)) }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
              <li class="nav-item">
                <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#tab-details" role="tab">
                  Détails
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-launch" role="tab">
                  Lancer formation
                </a>
              </li>
              @if(in_array($formation->status, ['in_progress','completed']))
                <li class="nav-item">
                  <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-presence" role="tab">
                    Présence
                  </a>
                </li>
              @endif
            </ul>

          </div>
        </div>
      </div>
    </div>
  </div>

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
                  <div class="text-body">{!! $formation->summary !!}</div>
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

            {{-- Statistiques & Progression --}}
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
                  <small class="text-muted">{{ $pct }}% des places remplies</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- end tab-details --}}

        {{-- Onglet Lancer formation --}}
        <div class="tab-pane fade" id="tab-launch" role="tabpanel">
          <div class="card">
            <div class="card-body">
              <h6 class="fw-semibold text-uppercase mb-3">Démarrer la formation</h6>

              @if($formation->status == 'available')
                <form action="{{ route('forma.formations.launch', $formation) }}"
                      method="POST"
                      id="launch-form">
                  @csrf
                  @if($formation->mode == 'a_distance')
                    <div class="mb-4">
                      <label for="link" class="form-label">Lien de la rencontre</label>
                      <input type="url"
                             name="link"
                             id="link"
                             class="form-control"
                             value="{{ old('link', $formation->link) }}"
                             required>
                    </div>
                  @endif
                  <button type="submit"
                          class="btn btn-success btn-lg mb-4"
                          id="launch-btn">
                    <i class="ri-play-line align-bottom"></i> Lancer la formation
                  </button>
                </form>
              @endif

              {{-- Listes utilisateurs --}}
              <div class="container mb-4">
                <div class="row">
                  <div class="col-sm-4">
                    <h6 class="fw-semibold text-uppercase mb-3">Confirmés</h6>
                    <ul class="list-group">
                      @foreach($formation->applicants as $u)
                        @if($u->pivot->user_confirmed)
                          <li class="list-group-item list-group-item-primary">
                            {{ $u->cin }} – {{ $u->prenom }} {{ $u->nom }}
                            ({{ optional($u->etablissement)->nom }})
                          </li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                  <div class="col-sm-4">
                    <h6 class="fw-semibold text-uppercase mb-3">Acceptés non confirmés</h6>
                    <ul class="list-group">
                      @foreach($formation->applicants as $u)
                        @if($u->pivot->status == 1 && ! $u->pivot->user_confirmed)
                          <li class="list-group-item list-group-item-secondary">
                            {{ $u->cin }} – {{ $u->prenom }} {{ $u->nom }}
                            ({{ optional($u->etablissement)->nom }})
                          </li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                  <div class="col-sm-4">
                    <h6 class="fw-semibold text-uppercase mb-3">Liste d’attente</h6>
                    <ul class="list-group">
                      @foreach($formation->applicants as $u)
                        @if($u->pivot->status == 3)
                          <li class="list-group-item list-group-item-warning">
                            {{ $u->cin }} – {{ $u->prenom }} {{ $u->nom }}
                            ({{ optional($u->etablissement)->nom }})
                          </li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>

              {{-- Marquer comme complétée --}}
              @if($formation->status == 'in_progress')
                <form action="{{ route('forma.formations.completed', $formation) }}"
                      method="POST"
                      class="mt-3">
                  @csrf
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="ri-check-line align-bottom"></i> Marquer comme complétée
                  </button>
                </form>
              @elseif($formation->status == 'completed')
                <div class="mt-4">
                  <h6 class="text-success">
                    <i class="ri-checkbox-circle-line"></i> Formation terminée
                  </h6>
                </div>
              @endif
            </div>
          </div>
        </div>
        {{-- end tab-launch --}}

        {{-- Présence Tab --}}
        @if(in_array($formation->status,['in_progress','completed']))
        <div class="tab-pane fade" id="tab-presence" role="tabpanel">
            <div class="card">
            <div class="card-body">
                <h6 class="fw-semibold text-uppercase mb-3">Gestion des présences</h6>

                {{-- 1) Date filter (GET → show) --}}
                <form method="GET"
                    action="{{ route('forma.formations.show', $formation) }}"
                    class="row g-2 mb-4">
                <div class="col-md-4">
                    <label for="presence_date" class="form-label">Date</label>
                    <input type="date"
                        id="presence_date"
                        name="date"
                        class="form-control"
                        value="{{ $date }}"
                        onchange="this.form.submit()">
                </div>
                </form>

                {{-- 2) Save presence (POST → storePresence) --}}
                <form method="POST"
                    action="{{ route('forma.formations.presence.store', $formation) }}">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>CIN</th>
                        <th>Nom</th>
                        <th class="text-center">Présent</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->cin }}</td>
                        <td>{{ $user->prenom }} {{ $user->nom }}</td>
                        <td class="text-center">
                            <div class="form-check form-switch">
                            <input class="form-check-input"
                                    type="checkbox"
                                    id="psw{{ $user->id }}"
                                    name="present[{{ $user->id }}]"
                                    value="1"
                                    {{ $records->get($user->id) ? 'checked' : '' }}>
                            </div>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">
                    Enregistrer les présences
                    </button>
                </div>
                </form>
            </div>
            </div>
        </div>
        @endif
        {{-- end tab-presence --}}

      </div>
    </div>
  </div>
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


<script>
document.addEventListener('DOMContentLoaded', function(){
  // if there's a "date" param in the URL, activate the Présence tab
  const params = new URLSearchParams(window.location.search);
  if (params.has('date')) {
    const presenceTabLink = document.querySelector('a[href="#tab-presence"]');
    if (presenceTabLink) {
      // bootstrap 5 way
      new bootstrap.Tab(presenceTabLink).show();
    }
  }
});
</script>


@endpush
