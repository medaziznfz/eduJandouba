@extends('layouts.app')

@push('styles')
    <!-- (You can add custom CSS here if needed) -->
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Liste des formations</h4>
        <a href="{{ route('univ.formations.create') }}" class="btn btn-success">
          <i class="ri-add-line align-bottom"></i> Créer formation
        </a>
      </div>
      <div class="card-body">
        <div class="listjs-table" id="formationList">
          
          <!-- Search bar -->
          <div class="row g-4 mb-3">
            <div class="col-sm-4">
              <div class="search-box">
                <input type="text" class="form-control search" placeholder="Rechercher...">
                <i class="ri-search-line search-icon"></i>
              </div>
            </div>
          </div>
          
          <!-- Table -->
          <div class="table-responsive table-card mt-3 mb-1">
            <table class="table align-middle table-nowrap" id="formationTable">
              <thead class="table-light">
                <tr>
                  <th class="sort" data-sort="titre">Titre</th>
                  <th class="sort" data-sort="duree">Durée</th>
                  <th class="sort" data-sort="sessions">Sessions</th>
                  <th class="sort" data-sort="capacite">Capacité</th>
                  <th class="sort" data-sort="deadline">Date limite</th>
                  <th class="sort" data-sort="status">Statut</th>
                  <th class="sort" data-sort="demandeur">Demandes</th>
                  <th class="sort" data-sort="inscrit">Inscrits</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="list">
                @foreach($formations as $f)
                <tr id="formation-{{ $f->id }}">
                  <td class="titre">{{ $f->titre }}</td>
                  <td class="duree">{{ $f->duree }}</td>
                  <td class="sessions">{{ $f->sessions }}</td>
                  <td class="capacite">{{ $f->capacite }}</td>
                  <td class="deadline">{{ $f->deadline->format('d/m/Y') }}</td>
                  <td class="status">
                    <span class="badge {{ $f->status_class }}">
                      {{ $f->status_label }}
                    </span>
                  </td>
                  <td class="demandeur">{{ $f->nbre_demandeur }}</td>
                  <td class="inscrit">{{ $f->nbre_inscrit }}</td>
                  <td class="action">
                    <div class="d-flex gap-2">
                      <a href="{{ route('univ.formations.show', $f) }}"
                         class="btn btn-sm btn-info">Voir</a>
                      <a href="{{ route('univ.formations.edit', $f) }}"
                         class="btn btn-sm btn-warning">Éditer</a>
                      <button class="btn btn-sm btn-danger"
                              onclick="deleteFormation({{ $f->id }})">
                        Supprimer
                      </button>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <!-- “no results” message -->
            <div class="noresult text-center p-4" style="display: none">
              <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                         trigger="loop"
                         colors="primary:#121331,secondary:#08a88a"
                         style="width:75px;height:75px"></lord-icon>
              <h5 class="mt-2">Aucune formation trouvée</h5>
            </div>

            <!-- “empty” message -->
            @if($formations->isEmpty())
              <div class="text-center p-4 empty-message">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                           trigger="loop"
                           colors="primary:#121331,secondary:#08a88a"
                           style="width:75px;height:75px"></lord-icon>
                <h5 class="mt-2">Vous n’avez créé aucune formation</h5>
              </div>
            @endif
          </div>

          <!-- List.js pagination controls -->
          <div class="d-flex justify-content-end">
            <div class="pagination-wrap hstack gap-2">
              <a class="page-item pagination-prev disabled" href="#">Précédent</a>
              <ul class="pagination listjs-pagination mb-0"></ul>
              <a class="page-item pagination-next" href="#">Suivant</a>
            </div>
          </div>

        </div><!-- /.listjs-table -->
      </div><!-- /.card-body -->
    </div><!-- /.card -->
  </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@push('scripts')
  <script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
  <script>
    // initialize List.js
    const formationList = new List('formationList', {
      valueNames: [
        'titre', 'duree', 'sessions', 'capacite',
        'deadline', 'status', 'demandeur', 'inscrit'
      ],
      page: 10,
      pagination: true
    });

    formationList.on('updated', function(list) {
      document.querySelector('.noresult').style.display =
        list.matchingItems.length === 0 ? 'block' : 'none';
    });

    // delete with SweetAlert2
    function deleteFormation(id) {
      Swal.fire({
        title: 'Supprimer cette formation ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler'
      }).then(result => {
        if (result.isConfirmed) {
          fetch(`/univ/formations/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
          }).then(res => {
            if (res.ok) {
              Swal.fire('Supprimée', 'La formation a été supprimée.', 'success');
              document.getElementById(`formation-${id}`).remove();
            }
          });
        }
      });
    }
  </script>
@endpush
