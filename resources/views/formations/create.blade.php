{{-- resources/views/formations/create.blade.php --}}
@extends('layouts.app')

@section('content')
  <div class="row mb-4">
    <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Créer une formation</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{ route('univ.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('univ.formations.index') }}">Formations</a></li>
          <li class="breadcrumb-item active">Créer</li>
        </ol>
      </div>
    </div>
  </div>

  <form action="{{ route('univ.formations.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">

            {{-- Titre --}}
            <div class="mb-3">
              <label for="titre" class="form-label">Titre</label>
              <input type="text" name="titre" id="titre"
                     class="form-control @error('titre') is-invalid @enderror"
                     value="{{ old('titre') }}" required>
              @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Miniature --}}
            <div class="mb-3">
              <label for="thumbnail" class="form-label">Miniature</label>
              <input type="file" name="thumbnail" id="thumbnail"
                     class="form-control @error('thumbnail') is-invalid @enderror"
                     accept="image/*">
              @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea name="description" id="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Résumé (TinyMCE) --}}
            <div class="mb-3">
              <label for="summary" class="form-label">Résumé (HTML)</label>
              <textarea name="summary" id="summary" rows="6"
                        class="form-control @error('summary') is-invalid @enderror">{{ old('summary') }}</textarea>
              @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
              {{-- Durée --}}
              <div class="col-md-4 mb-3">
                <label for="duree" class="form-label">Durée</label>
                <input type="text" name="duree" id="duree" placeholder="Ex : 3 mois"
                       class="form-control @error('duree') is-invalid @enderror"
                       value="{{ old('duree') }}" required>
                @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              {{-- Lieu --}}
              <div class="col-md-4 mb-3">
                <label for="lieu" class="form-label">Lieu</label>
                <input type="text" name="lieu" id="lieu" placeholder="Ville / Établissement"
                       class="form-control @error('lieu') is-invalid @enderror"
                       value="{{ old('lieu') }}" required>
                @error('lieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="row">
              {{-- Sessions --}}
              <div class="col-md-4 mb-3">
                <label for="sessions" class="form-label">Sessions</label>
                <select name="sessions" id="sessions"
                        class="form-select @error('sessions') is-invalid @enderror" required>
                  <option value="">-- Sélectionnez --</option>
                  <option value="1" {{ old('sessions')=='1'? 'selected':'' }}>1</option>
                  <option value="2" {{ old('sessions')=='2'? 'selected':'' }}>2</option>
                  <option value="3" {{ old('sessions')=='3'? 'selected':'' }}>3</option>
                </select>
                @error('sessions')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Date limite --}}
              <div class="col-md-8 mb-3">
                <label for="deadline" class="form-label">Date limite</label>
                <input type="date" name="deadline" id="deadline"
                       class="form-control @error('deadline') is-invalid @enderror"
                       value="{{ old('deadline') }}"
                       min="{{ date('Y-m-d') }}" required>
                @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Capacité --}}
              <div class="col-md-4 mb-3">
                <label for="capacite" class="form-label">Capacité</label>
                <input type="number" name="capacite" id="capacite" min="1"
                       class="form-control @error('capacite') is-invalid @enderror"
                       value="{{ old('capacite') }}" required>
                @error('capacite')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Date de début --}}
              <div class="col-md-8 mb-3">
                <label for="start_at" class="form-label">Date de début</label>
                <input type="date" name="start_at" id="start_at"
                       class="form-control @error('start_at') is-invalid @enderror"
                       value="{{ old('start_at') }}"
                       min="{{ old('deadline', date('Y-m-d')) }}" required>
                @error('start_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            {{-- Mode --}}
            <div class="mb-3">
              <label for="mode" class="form-label">Mode</label>
              <select name="mode" id="mode"
                      class="form-select @error('mode') is-invalid @enderror" required>
                <option value="presentielle" {{ old('mode')=='presentielle'? 'selected':'' }}>Présentielle</option>
                <option value="a_distance"   {{ old('mode')=='a_distance'?   'selected':'' }}>À distance</option>
              </select>
              @error('mode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Formateur --}}
            <div class="mb-3">
              <label for="formateur" class="form-label">Formateur</label>
              <select id="formateur" name="formateur_id"
                      class="form-select @error('formateur_id') is-invalid @enderror" required>
                <option value="">-- Sélectionnez --</option>
                @foreach($formateurs as $f)
                  <option value="{{ $f->id }}"
                    {{ old('formateur_id')==$f->id ? 'selected':'' }}>
                    {{ $f->cin }} — {{ $f->prenom }} {{ $f->nom }}
                  </option>
                @endforeach
              </select>
              @error('formateur_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Grades --}}
            <div class="mb-3">
              <label class="form-label d-block">Grades concernés</label>
              @foreach($grades as $grade)
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox"
                         id="grade{{ $grade->id }}" name="grades[]"
                         value="{{ $grade->id }}"
                         {{ in_array($grade->id, old('grades', [])) ? 'checked' : '' }}>
                  <label class="form-check-label" for="grade{{ $grade->id }}">{{ $grade->nom }}</label>
                </div>
              @endforeach
              @error('grades')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-success">Créer</button>
            </div>

          </div>
        </div>
      </div>
      <div class="col-lg-4"></div>
    </div>
  </form>
@endsection

@push('scripts')
  <!-- TinyMCE v7 -->
  <script src="https://cdn.tiny.cloud/1/ecpdzputo2ujf94cdjincgez6pw1q7hh7vdaflsqjsok11v5/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Init TinyMCE
    tinymce.init({
      selector: '#summary',
      plugins: 'link image lists table',
      toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image'
    });

    // Get references to the inputs
    var deadlineInput = document.getElementById('deadline'),
        startInput    = document.getElementById('start_at');

    // Compute today's date string (YYYY-MM-DD)
    var today = new Date().toISOString().split('T')[0];

    // Enforce: deadline ≥ today, and start_at ≥ deadline
    function updateDeadlineMin() {
      // Set the minimum for deadline
      deadlineInput.min = today;
      // If user already picked a past date, clamp it up to today
      if (deadlineInput.value && deadlineInput.value < today) {
        deadlineInput.value = today;
      }
      // After deadline changes, also update start_at
      updateStartMin();
    }

    function updateStartMin() {
      if (deadlineInput.value) {
        // start_at must be ≥ the chosen deadline
        startInput.min = deadlineInput.value;
        // If the user had a start_at before the new deadline, clamp it
        if (startInput.value && startInput.value < deadlineInput.value) {
          startInput.value = deadlineInput.value;
        }
      } else {
        // If no deadline yet, ensure start_at ≥ today
        startInput.min = today;
      }
    }

    // Run once on load
    updateDeadlineMin();

    // Wire up change handler on deadline
    deadlineInput.addEventListener('change', updateDeadlineMin);
  });
  </script>
@endpush

