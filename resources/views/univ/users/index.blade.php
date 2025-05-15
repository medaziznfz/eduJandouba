@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card" id="userList">

      {{-- Header with search --}}
      <div class="card-header border-0">
        <div class="d-md-flex align-items-center">
          <h5 class="card-title mb-3 mb-md-0 flex-grow-1">Utilisateurs</h5>
          <div class="flex-shrink-0">
            <div class="search-box">
              <input type="text" class="form-control search" placeholder="Rechercher des utilisateurs…" value="{{ request()->search }}">
              <i class="ri-search-line search-icon"></i>
            </div>
          </div>
        </div>
      </div>

      {{-- Role-based tabs --}}
      <div class="card-body pt-0">
        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
          {{-- Only show the 'Établissement' tab --}}
          <li class="nav-item">
            <a class="nav-link active" data-status="etab" href="#">Utilisateurs</a>
          </li>
        </ul>

        {{-- Table --}}
        <div class="table-responsive table-card mb-1">
          <table class="table table-nowrap align-middle" id="userListTable">
            <thead class="text-muted table-light">
              <tr class="text-uppercase">
                <th><div class="form-check"><input class="form-check-input" type="checkbox" id="checkAll"></div></th>
                <th class="sort" data-sort="id" style="width:140px;">ID</th>
                <th class="sort" data-sort="prenom">Prénom</th>
                <th class="sort" data-sort="nom">Nom</th>
                <th class="sort" data-sort="email">Email</th>
                <th class="sort" data-sort="cin" style="width:120px;">CIN</th>
                <th class="sort" data-sort="etablissement">Établissement</th>
                <th class="sort" data-sort="role">Rôle</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody class="list">
              @foreach($etabUsers as $user)
                <tr data-status="{{ $user->role }}">
                  <th scope="row">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="selected[]" value="{{ $user->id }}">
                    </div>
                  </th>
                  <td class="id">{{ $user->id }}</td>
                  <td class="prenom">{{ $user->prenom }}</td>
                  <td class="nom">{{ $user->nom }}</td>
                  <td class="email">{{ $user->email }}</td>
                  <td class="cin">{{ $user->cin }}</td>
                  <td class="etablissement">{{ optional($user->etablissement)->nom ?? 'Non défini' }}</td>
                  <td class="role">{{ ucfirst($user->role) }}</td>
                  <td class="text-end">
                    <ul class="list-inline hstack gap-2 mb-0">
                      {{-- Edit --}}
                      <li class="list-inline-item" data-bs-toggle="tooltip" title="Éditer">
                        <a href="{{ route('etab.users.edit', $user->id) }}" class="text-primary">
                          <i class="ri-pencil-fill fs-16"></i>
                        </a>
                      </li>

                      {{-- Delete --}}
                      <li class="list-inline-item" data-bs-toggle="tooltip" title="Supprimer">
                        <form action="{{ route('etab.users.destroy', $user->id) }}" method="POST" class="d-inline-block form-action" data-action="delete">
                          @csrf @method('DELETE')
                          <button type="submit" class="btn p-0 m-0 text-danger">
                            <i class="ri-delete-bin-5-fill fs-16"></i>
                          </button>
                        </form>
                      </li>
                    </ul>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <div class="noresult text-center p-4" style="display:none;">
            <p class="text-muted mb-0">Désolé ! Aucun résultat trouvé.</p>
          </div>
        </div>

        {{-- Pagination --}}
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

{{-- Modale Show --}}
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showModalLabel">Détails de l'utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <dl class="row">
          <dt class="col-sm-3">Prénom</dt><dd class="col-sm-9" id="modalUser">—</dd>
          <dt class="col-sm-3">Nom</dt><dd class="col-sm-9" id="modalNom">—</dd>
          <dt class="col-sm-3">Email</dt><dd class="col-sm-9" id="modalEmail">—</dd>
          <dt class="col-sm-3">CIN</dt><dd class="col-sm-9" id="modalCin">—</dd>
          <dt class="col-sm-3">Grade</dt><dd class="col-sm-9" id="modalGrade">—</dd>
          <dt class="col-sm-3">Rôle</dt><dd class="col-sm-9" id="modalRole">—</dd>
          <dt class="col-sm-3">Établissement</dt><dd class="col-sm-9" id="modalEtablissement">—</dd>
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
  // Init List.js for user list
  const listObj = new List('userList', {
    valueNames: ['id', 'prenom', 'nom', 'email', 'cin', 'etablissement', 'role'],
    page: 10,
    pagination: true,
    searchClass: 'search'
  });

  // Display "No result" message
  const noResult = document.querySelector('.noresult');
  listObj.on('updated', function(list) {
    noResult.style.display = list.matchingItems.length === 0 ? 'block' : 'none';
  });

  // Show modal for user details
  const showModalEl = document.getElementById('showModal');
  showModalEl.addEventListener('show.bs.modal', event => {
    const btn = event.relatedTarget;
    const map = {
      modalUser: 'user', modalNom: 'nom', modalEmail: 'email',
      modalCin: 'cin', modalGrade: 'grade', modalRole: 'role', modalEtablissement: 'etablissement'
    };
    Object.entries(map).forEach(([dd, attr]) => {
      const val = btn.getAttribute('data-' + attr) || '—';
      showModalEl.querySelector('#' + dd).textContent = val;
    });
  });

  // Delete user confirmation with SweetAlert
  document.querySelectorAll('.form-action').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      let title = 'Êtes-vous sûr de vouloir supprimer cet utilisateur ?';
      Swal.fire({
        title, icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
      }).then(res => res.isConfirmed && form.submit());
    });
  });

  // Notifications flash with SweetAlert
  @if(session('success'))
    Swal.fire({ icon: 'success', title: '{{ session('success') }}', timer: 2000, showConfirmButton: false });
  @endif
  @if(session('error'))
    Swal.fire({ icon: 'error', title: '{{ session('error') }}', timer: 2000, showConfirmButton: false });
  @endif
});
</script>
@endpush
