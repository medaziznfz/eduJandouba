@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card" id="applicationList">

      {{-- en-tête avec recherche --}}
      <div class="card-header border-0">
        <div class="d-md-flex align-items-center">
          <h5 class="card-title mb-3 mb-md-0 flex-grow-1">Candidatures</h5>
          <div class="flex-shrink-0">
            <div class="search-box">
              <input type="text" id="searchInput" class="form-control" placeholder="Rechercher des candidatures…">
              <i class="ri-search-line search-icon"></i>
            </div>
          </div>
        </div>
      </div>

      {{-- onglets de statut --}}
      <div class="card-body pt-0">
        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-status="all" href="#">Toutes</a>
          </li>
          @foreach($statusLabels as $code => $label)
            @php $count = $applications->where('status',(int)$code)->count(); @endphp
            <li class="nav-item">
              <a class="nav-link" data-status="{{ $code }}" href="#">
                {{ $label }}
                @if($count > 0)
                  <span class="badge bg-danger align-middle ms-1">{{ $count }}</span>
                @endif
              </a>
            </li>
          @endforeach
        </ul>

        {{-- tableau --}}
        <div class="table-responsive table-card mb-1">
          <table class="table table-nowrap align-middle" id="jobListTable">
            <thead class="text-muted table-light">
              <tr class="text-uppercase">
                <th style="width:25px;">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkAll">
                  </div>
                </th>
                <th class="sort" data-sort="id" style="width:140px;">ID candidature</th>
                <th class="sort" data-sort="formation">Formation</th>
                <th class="sort" data-sort="applicant">Candidat</th>
                <th class="sort" data-sort="date">Date de dépôt</th>
                <th class="sort" data-sort="status">Statut</th>
                <th class="sort" data-sort="etab-val">Validation Étab</th>
                <th class="sort" data-sort="univ-val">Validation Univ</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($applications as $app)
                <tr data-status="{{ $app->status }}">
                  <th scope="row">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="selected[]" value="{{ $app->id }}">
                    </div>
                  </th>
                  <td class="id">#{{ $app->id }}</td>
                  <td class="formation">{{ $app->formation->titre }}</td>
                  <td class="applicant">{{ $app->user->prenom }} {{ $app->user->nom }}</td>
                  <td class="date">{{ $app->created_at->format('d M, Y') }}</td>
                  <td class="status">
                    <span class="badge
                      {{ $app->status === 0 ? 'bg-warning-subtle text-warning' :
                         ($app->status === 1 ? 'bg-success-subtle text-success' :
                         ($app->status === 2 ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary')) }}">
                      {{ $statusLabels[$app->status] }}
                    </span>
                  </td>
                  <td class="etab-val">
                    <span class="badge {{ $app->etab_confirmed ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                      {{ $app->etab_confirmed ? 'Oui' : 'Non' }}
                    </span>
                  </td>
                  <td class="univ-val">
                    <span class="badge {{ $app->univ_confirmed ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                      {{ $app->univ_confirmed ? 'Oui' : 'Non' }}
                    </span>
                  </td>
                  <td class="text-end">
                    <ul class="list-inline hstack gap-2 mb-0">

                      {{-- Voir --}}
                      <li class="list-inline-item" data-bs-toggle="tooltip" title="Voir">
                        <a href="#"
                           class="text-primary btn-show"
                           data-bs-toggle="modal"
                           data-bs-target="#showModal"
                           data-created="{{ $app->created_at->format('d M, Y H:i') }}"
                           data-user="{{ $app->user->prenom }} {{ $app->user->nom }}"
                           data-email="{{ $app->user->email }}"
                           data-cin="{{ $app->user->cin }}"
                           data-etab="{{ optional($app->user->etablissement)->nom }}"
                           data-grade="{{ optional($app->user->grade)->nom }}"
                           data-formation="{{ $app->formation->titre }}"
                           data-deadline="{{ $app->formation->deadline->format('d M, Y') }}"
                           data-desc="{{ $app->formation->description }}"
                           data-duree="{{ $app->formation->duree }}"
                           data-lieu="{{ $app->formation->lieu }}"
                           data-capacite="{{ $app->formation->capacite }}"
                           data-sessions="{{ $app->formation->sessions }}"
                           data-mode="{{ $app->formation->mode }}"
                           data-nbre-dem="{{ $app->formation->nbre_demandeur }}"
                           data-nbre-ins="{{ $app->formation->nbre_inscrit }}">
                          <i class="ri-eye-fill fs-16"></i>
                        </a>
                      </li>

                      {{-- Accepter --}}
                      <li class="list-inline-item" data-bs-toggle="tooltip" title="Accepter">
                        <form action="{{ route('etab.applications.accept', $app->id) }}"
                              method="POST"
                              class="d-inline-block form-action"
                              data-action="accept">
                          @csrf
                          <button type="submit" class="btn p-0 m-0 text-success">
                            <i class="ri-checkbox-multiple-fill fs-16"></i>
                          </button>
                        </form>
                      </li>

                      {{-- Rejeter --}}
                      <li class="list-inline-item" data-bs-toggle="tooltip" title="Rejeter">
                        <form action="{{ route('etab.applications.reject', $app->id) }}"
                              method="POST"
                              class="d-inline-block form-action"
                              data-action="reject">
                          @csrf
                          <button type="submit" class="btn p-0 m-0 text-danger">
                            <i class="ri-close-circle-line fs-16"></i>
                          </button>
                        </form>
                      </li>

                      {{-- Supprimer --}}
                      <li class="list-inline-item" data-bs-toggle="tooltip" title="Supprimer">
                        <form action="{{ route('etab.applications.destroy', $app->id) }}"
                              method="POST"
                              class="d-inline-block form-action"
                              data-action="delete">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn p-0 m-0 text-danger">
                            <i class="ri-delete-bin-5-fill fs-16"></i>
                          </button>
                        </form>
                      </li>

                    </ul>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center">Aucune candidature trouvée.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          <div class="noresult text-center p-4" style="display:none;">
            <p class="text-muted mb-0">Désolé ! Aucun résultat trouvé.</p>
          </div>
        </div>

        {{-- pagination --}}
        <div class="d-flex justify-content-end">
          <div class="pagination-wrap hstack gap-2">
            <a class="page-item pagination-prev disabled" href="#">Précédent</a>
            <ul class="pagination listjs-pagination mb-0"></ul>
            <a class="page-item pagination-next" href="#">Suivant</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modale scrollable de détails --}}
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showModalLabel">Détails de la candidature</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <dl class="row">
          {{-- Métadonnées --}}
          <dt class="col-sm-3">Créée le</dt>
          <dd class="col-sm-9" id="modalCreated"></dd>

          {{-- Utilisateur --}}
          <dt class="col-sm-3">Candidat</dt>
          <dd class="col-sm-9" id="modalUser"></dd>
          <dt class="col-sm-3">Email</dt>
          <dd class="col-sm-9" id="modalEmail"></dd>
          <dt class="col-sm-3">CIN</dt>
          <dd class="col-sm-9" id="modalCin"></dd>
          <dt class="col-sm-3">Établissement</dt>
          <dd class="col-sm-9" id="modalEtab"></dd>
          <dt class="col-sm-3">Grade</dt>
          <dd class="col-sm-9" id="modalGrade"></dd>

          {{-- Formation --}}
          <dt class="col-sm-3">Formation</dt>
          <dd class="col-sm-9" id="modalFormation"></dd>
          <dt class="col-sm-3">Deadline</dt>
          <dd class="col-sm-9" id="modalDeadline"></dd>
          <dt class="col-sm-3">Description</dt>
          <dd class="col-sm-9" id="modalDesc"></dd>
          <dt class="col-sm-3">Durée</dt>
          <dd class="col-sm-9" id="modalDuree"></dd>
          <dt class="col-sm-3">Lieu</dt>
          <dd class="col-sm-9" id="modalLieu"></dd>
          <dt class="col-sm-3">Capacité</dt>
          <dd class="col-sm-9" id="modalCapacite"></dd>
          <dt class="col-sm-3">Sessions</dt>
          <dd class="col-sm-9" id="modalSessions"></dd>
          <dt class="col-sm-3">Mode</dt>
          <dd class="col-sm-9" id="modalMode"></dd>
          <dt class="col-sm-3">Demandes</dt>
          <dd class="col-sm-9" id="modalNbreDem"></dd>
          <dt class="col-sm-3">Inscrits</dt>
          <dd class="col-sm-9" id="modalNbreIns"></dd>
        </dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
<script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Filtrage List.js
  const rows = Array.from(document.querySelectorAll('#jobListTable tbody tr'));
  const searchInput = document.getElementById('searchInput');
  const tabs = document.querySelectorAll('.nav-tabs-custom .nav-link[data-status]');
  let activeStatus = 'all';

  function filterData() {
    const q = searchInput.value.trim().toLowerCase();
    let anyVisible = false;
    rows.forEach(r => {
      const stat = r.dataset.status;
      const txt = r.textContent.toLowerCase();
      let show = (activeStatus === 'all' || stat === activeStatus);
      if (q && !txt.includes(q)) show = false;
      r.style.display = show ? '' : 'none';
      if (show) anyVisible = true;
    });
    document.querySelector('.noresult').style.display = anyVisible ? 'none' : '';
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
      e.preventDefault();
      tabs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');
      activeStatus = this.dataset.status;
      filterData();
    });
  });

  searchInput.addEventListener('input', filterData);
  filterData();

  // SweetAlert confirm dialogs
  document.querySelectorAll('.form-action').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const action = form.dataset.action;
      let title = '';
      if (action === 'accept') title = 'Accepter cette candidature ?';
      if (action === 'reject') title = 'Rejeter cette candidature ?';
      if (action === 'delete') title = 'Supprimer cette candidature ?';

      Swal.fire({
        title: title,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Annuler'
      }).then(result => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  // Flash messages
  @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: '{{ session('success') }}',
      timer: 2000,
      showConfirmButton: false
    });
  @endif
  @if(session('error'))
    Swal.fire({
      icon: 'error',
      title: '{{ session('error') }}',
      timer: 2000,
      showConfirmButton: false
    });
  @endif

  // Modal population
  const showModalEl = document.getElementById('showModal');
  showModalEl.addEventListener('show.bs.modal', function(event) {
    const btn = event.relatedTarget;
    const map = {
      modalCreated: 'created',
      modalUser: 'user',
      modalEmail: 'email',
      modalCin: 'cin',
      modalEtab: 'etab',
      modalGrade: 'grade',
      modalFormation: 'formation',
      modalDeadline: 'deadline',
      modalDesc: 'desc',
      modalDuree: 'duree',
      modalLieu: 'lieu',
      modalCapacite: 'capacite',
      modalSessions: 'sessions',
      modalMode: 'mode',
      modalNbreDem: 'nbre-dem',
      modalNbreIns: 'nbre-ins'
    };
    Object.entries(map).forEach(([dd, dataAttr]) => {
      showModalEl.querySelector('#' + dd).textContent =
        btn.getAttribute('data-' + dataAttr) || '—';
    });
  });
});
</script>
@endpush
