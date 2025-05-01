@extends('layouts.app')

@push('styles')
    <!-- Ajoutez ici vos styles spécifiques si besoin -->
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Liste des demandes à valider</h4>
      </div>

      <div class="card-body">
        <div class="listjs-table" id="demandeList">
          <!-- Boutons de masse -->
          <div class="row g-4 mb-3">
            <div class="col-sm-auto">
              <button class="btn btn-success" onclick="updateMultiple()">
                <i class="ri-refresh-line"></i> Confirmer les demandes
              </button>
              <button class="btn btn-soft-danger" onclick="deleteMultiple()">
                <i class="ri-delete-bin-2-line"></i> Supprimer
              </button>
            </div>
            <div class="col-sm">
              <div class="d-flex justify-content-sm-end">
                <div class="search-box ms-2">
                  <input type="text" class="form-control search" placeholder="Rechercher...">
                  <i class="ri-search-line search-icon"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Tableau -->
          <div class="table-responsive table-card mt-3 mb-1">
            <table class="table align-middle table-nowrap" id="customerTable">
              <thead class="table-light">
                <tr>
                  <th style="width: 50px;">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="checkAll">
                    </div>
                  </th>
                  <th class="sort" data-sort="cin">CIN</th>
                  <th class="sort" data-sort="name">Nom complet</th>
                  <th class="sort" data-sort="email">Email</th>
                  <th class="sort" data-sort="grade">Grade</th>
                  <th class="sort" data-sort="status">Statut</th>
                  <th class="sort" data-sort="action">Action</th>
                </tr>
              </thead>
              <tbody class="list form-check-all">
                @foreach($demandes as $demande)
                  <tr id="demande-{{ $demande->id }}">
                    <td>
                      <div class="form-check">
                        <input class="form-check-input select-checkbox" type="checkbox" value="{{ $demande->id }}">
                      </div>
                    </td>
                    <td class="cin">{{ $demande->cin }}</td>
                    <td class="name">{{ $demande->prenom }} {{ $demande->nom }}</td>
                    <td class="email">{{ $demande->email }}</td>
                    <td class="grade">{{ $demande->grade->nom ?? '-' }}</td>
                    <td class="status">
                      <span class="badge {{ $demande->status_class }} text-uppercase">
                        {{ $demande->status_label }}
                      </span>
                    </td>
                    <td class="action">
                      <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success" onclick="updateStatus({{ $demande->id }})">
                          Confirmer
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="declineDemande({{ $demande->id }})">
                          Refuser
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteDemande({{ $demande->id }})">
                          Supprimer
                        </button>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            <!-- Message pas de résultat -->
            <div class="noresult text-center p-4" style="display: none">
              <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                         trigger="loop"
                         colors="primary:#121331,secondary:#08a88a"
                         style="width:75px;height:75px"></lord-icon>
              <h5 class="mt-2">Aucun résultat trouvé</h5>
              <p class="text-muted mb-0">
                Nous n'avons trouvé aucune demande correspondant à votre recherche.
              </p>
            </div>

            <!-- Message aucune demande -->
            @if($demandes->isEmpty())
              <div class="text-center p-4 empty-message">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                           trigger="loop"
                           colors="primary:#121331,secondary:#08a88a"
                           style="width:75px;height:75px"></lord-icon>
                <h5 class="mt-2">Aucune demande disponible</h5>
                <p class="text-muted mb-0">Il n'y a actuellement aucune demande à valider.</p>
              </div>
            @endif
          </div>

          <!-- Pagination -->
          <div class="d-flex justify-content-end">
            <div class="pagination-wrap hstack gap-2">
              <a class="page-item pagination-prev disabled" href="#">Précédent</a>
              <ul class="pagination listjs-pagination mb-0"></ul>
              <a class="page-item pagination-next" href="#">Suivant</a>
            </div>
          </div>
        </div> <!-- .listjs-table -->
      </div><!-- .card-body -->
    </div><!-- .card -->
  </div><!-- .col -->
</div><!-- .row -->
@endsection

@push('scripts')
  <script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
  <script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
  <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

  <script>
    // Récupère les IDs cochés
    function getSelectedIds() {
      return Array.from(document.querySelectorAll('.select-checkbox:checked'))
                  .map(cb => cb.value);
    }

    // Confirmer une demande unique
    function updateStatus(id) {
      Swal.fire({
        title: 'Confirmer la demande ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Non'
      }).then(result => {
        if (result.isConfirmed) {
          fetch(`/etab/demande/${id}/update-status`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            }
          }).then(() => window.location.reload());
        }
      });
    }

    // Confirmer plusieurs demandes
    function updateMultiple() {
      const selected = getSelectedIds();
      if (selected.length === 0) {
        return Swal.fire('Aucune sélection', 'Veuillez sélectionner au moins une demande.', 'warning');
      }
      Swal.fire({
        title: `Confirmer ${selected.length} demande(s) ?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Non'
      }).then(result => {
        if (result.isConfirmed) {
          fetch('/etab/demandes/batch-update', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids: selected })
          }).then(() => window.location.reload());
        }
      });
    }

    // Supprimer une demande unique
    function deleteDemande(id) {
      Swal.fire({
        title: 'Supprimer cette demande ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler'
      }).then(result => {
        if (result.isConfirmed) {
          fetch(`/etab/demande/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
          }).then(() => window.location.reload());
        }
      });
    }

    // Supprimer plusieurs demandes
    function deleteMultiple() {
      const selected = getSelectedIds();
      if (selected.length === 0) {
        return Swal.fire('Aucune sélection', 'Veuillez sélectionner au moins une demande.', 'warning');
      }
      Swal.fire({
        title: `Supprimer ${selected.length} demande(s) ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Annuler'
      }).then(result => {
        if (result.isConfirmed) {
          fetch('/etab/demandes/batch-delete', {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids: selected })
          }).then(() => window.location.reload());
        }
      });
    }

    // Refuser une demande avec motif
    function declineDemande(id) {
      Swal.fire({
        title: 'Refuser la demande ?',
        text: 'Veuillez indiquer le motif du refus',
        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: 'Entrez le motif...',
        showCancelButton: true,
        confirmButtonText: 'Refuser',
        cancelButtonText: 'Annuler',
        preConfirm: reason => {
          if (!reason) {
            Swal.showValidationMessage('Le motif est requis');
          } else {
            return fetch(`/etab/demande/${id}/decline`, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
              },
              body: JSON.stringify({ reason })
            })
            .then(response => {
              if (!response.ok) throw new Error(response.statusText);
              return response.json();
            })
            .catch(error => {
              Swal.showValidationMessage(`Erreur: ${error}`);
            });
          }
        }
      }).then(result => {
        if (result.isConfirmed) {
          Swal.fire('Demande refusée', 'Le candidat a été informé.', 'success')
               .then(() => window.location.reload());
        }
      });
    }

    // Init List.js pour recherche + pagination
    const demandeList = new List('demandeList', {
      valueNames: ['cin','name','email','grade','status','action'],
      page: 10,
      pagination: true
    });
    demandeList.on('updated', function(list) {
      const noResult = document.querySelector('.noresult');
      noResult.style.display = list.matchingItems.length === 0 ? 'block' : 'none';
    });
  </script>
@endpush
