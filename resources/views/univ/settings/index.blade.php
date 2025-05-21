{{-- resources/views/univ/settings/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row flex-wrap">
  <div class="col-xxl-12">
    <h5 class="mb-3">Gestion des Grades &amp; Établissements</h5>
    <div class="card">
      <div class="card-body">
        <div class="row">
          {{-- Nav --}}
          <div class="col-lg-3">
            <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center"
                 role="tablist" aria-orientation="vertical">
              <a class="nav-link active show"
                 id="v-pills-grades-tab"
                 data-bs-toggle="pill"
                 href="#v-pills-grades"
                 role="tab">
                <i class="ri-list-unordered d-block fs-20 mb-1"></i>
                Grades
              </a>
              <a class="nav-link"
                 id="v-pills-etabs-tab"
                 data-bs-toggle="pill"
                 href="#v-pills-etabs"
                 role="tab">
                <i class="ri-building-2-line d-block fs-20 mb-1"></i>
                Établissements
              </a>
            </div>
          </div><!-- end col-->

          {{-- Content --}}
          <div class="col-lg-9">
            <div class="tab-content mt-3 mt-lg-0">

              {{-- Grades Tab --}}
              <div class="tab-pane fade active show" id="v-pills-grades" role="tabpanel">
                {{-- Create Grade --}}
                <form id="grade-create-form"
                      action="{{ route('univ.settings.grades.store') }}"
                      method="POST"
                      class="mb-4">
                  @csrf
                  <div class="input-group">
                    <input name="nom" class="form-control" placeholder="Nouveau grade" required>
                    <input name="description" class="form-control" placeholder="Description (facultatif)">
                    <button class="btn btn-primary">Ajouter</button>
                  </div>
                </form>

                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($grades as $grade)
                      <tr>
                        <td>{{ $grade->id }}</td>
                        <td>
                          <input form="grade-update-{{ $grade->id }}"
                                 name="nom"
                                 value="{{ $grade->nom }}"
                                 class="form-control">
                        </td>
                        <td>
                          <input form="grade-update-{{ $grade->id }}"
                                 name="description"
                                 value="{{ $grade->description }}"
                                 class="form-control">
                        </td>
                        <td>
                          <div class="hstack gap-2">
                            {{-- Update --}}
                            <form id="grade-update-{{ $grade->id }}"
                                  action="{{ route('univ.settings.grades.update', $grade) }}"
                                  method="POST">
                              @csrf @method('PATCH')
                              <button class="btn btn-sm btn-success">
                                <i class="ri-edit-2-line"></i>
                              </button>
                            </form>
                            {{-- Delete --}}
                            <form class="grade-delete-form"
                                  action="{{ route('univ.settings.grades.destroy', $grade) }}"
                                  method="POST">
                              @csrf @method('DELETE')
                              <button class="btn btn-sm btn-danger">
                                <i class="ri-delete-bin-line"></i>
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- end Grades -->

              {{-- Etablissements Tab --}}
              <div class="tab-pane fade" id="v-pills-etabs" role="tabpanel">
                {{-- Create Etablissement --}}
                <form id="etab-create-form"
                      action="{{ route('univ.settings.etablissements.store') }}"
                      method="POST"
                      class="mb-4">
                  @csrf
                  <div class="input-group">
                    <input name="nom" class="form-control" placeholder="Nouvel établissement" required>
                    <input name="description" class="form-control" placeholder="Description (facultatif)">
                    <button class="btn btn-primary">Ajouter</button>
                  </div>
                </form>

                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($etablissements as $etab)
                      <tr>
                        <td>{{ $etab->id }}</td>
                        <td>
                          <input form="etab-update-{{ $etab->id }}"
                                 name="nom"
                                 value="{{ $etab->nom }}"
                                 class="form-control">
                        </td>
                        <td>
                          <input form="etab-update-{{ $etab->id }}"
                                 name="description"
                                 value="{{ $etab->description }}"
                                 class="form-control">
                        </td>
                        <td>
                          <div class="hstack gap-2">
                            {{-- Update --}}
                            <form id="etab-update-{{ $etab->id }}"
                                  action="{{ route('univ.settings.etablissements.update', $etab) }}"
                                  method="POST">
                              @csrf @method('PATCH')
                              <button class="btn btn-sm btn-success">
                                <i class="ri-edit-2-line"></i>
                              </button>
                            </form>
                            {{-- Delete --}}
                            <form class="etab-delete-form"
                                  action="{{ route('univ.settings.etablissements.destroy', $etab) }}"
                                  method="POST">
                              @csrf @method('DELETE')
                              <button class="btn btn-sm btn-danger">
                                <i class="ri-delete-bin-line"></i>
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- end Etabs -->

            </div><!-- end tab-content -->
          </div><!-- end col-->
        </div><!-- end row-->
      </div><!-- end card-body -->
    </div><!-- end card-->
  </div><!-- end col-->
</div><!-- end row -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Generic confirmation handler
  function confirmAndSubmit(form, message) {
    Swal.fire({
      title: message,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Oui',
      cancelButtonText: 'Non'
    }).then(result => {
      if (result.isConfirmed) form.submit();
    });
  }

  // Create forms
  document.getElementById('grade-create-form')
    .addEventListener('submit', e => {
      e.preventDefault();
      confirmAndSubmit(e.target, 'Ajouter ce grade ?');
    });
  document.getElementById('etab-create-form')
    .addEventListener('submit', e => {
      e.preventDefault();
      confirmAndSubmit(e.target, 'Ajouter cet établissement ?');
    });

  // Update forms
  document.querySelectorAll('form[id^="grade-update-"], form[id^="etab-update-"]')
    .forEach(f => {
      f.addEventListener('submit', e => {
        e.preventDefault();
        confirmAndSubmit(e.target, 'Enregistrer les modifications ?');
      });
    });

  // Delete forms
  document.querySelectorAll('.grade-delete-form, .etab-delete-form')
    .forEach(f => {
      f.addEventListener('submit', e => {
        e.preventDefault();
        confirmAndSubmit(e.target, 'Supprimer définitivement ?');
      });
    });
});
</script>
@endpush
