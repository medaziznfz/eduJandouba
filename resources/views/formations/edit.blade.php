{{-- resources/views/formations/edit.blade.php --}}
@extends('layouts.app')

@section('content')
  <div class="row mb-4">
    <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Modifier la formation</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{ route('univ.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('univ.formations.index') }}">Formations</a></li>
          <li class="breadcrumb-item active">Éditer</li>
        </ol>
      </div>
    </div>
  </div>

  <form action="{{ route('univ.formations.update', $formation) }}"
        method="POST"
        enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row">
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">

            {{-- Titre --}}
            <div class="mb-3">
              <label for="titre" class="form-label">Titre</label>
              <input type="text"
                     name="titre"
                     id="titre"
                     class="form-control @error('titre') is-invalid @enderror"
                     value="{{ old('titre', $formation->titre) }}"
                     required>
              @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Miniature --}}
            <div class="mb-3">
              <label for="thumbnail" class="form-label">Miniature</label>
              <input type="file"
                     name="thumbnail"
                     id="thumbnail"
                     class="form-control @error('thumbnail') is-invalid @enderror"
                     accept="image/*">
              @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror

              @if($formation->thumbnail)
                <div class="mt-2">
                  <img src="{{ asset('storage/'.$formation->thumbnail) }}"
                       style="max-height:100px;" alt="Miniature actuelle">
                </div>
              @endif
            </div>

            {{-- Description --}}
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea name="description"
                        id="description"
                        rows="3"
                        class="form-control @error('description') is-invalid @enderror"
              >{{ old('description', $formation->description) }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Résumé (TinyMCE) --}}
            <div class="mb-3">
              <label for="summary" class="form-label">Résumé (HTML)</label>
              <textarea name="summary"
                        id="summary"
                        rows="6"
                        class="form-control @error('summary') is-invalid @enderror"
              >{{ old('summary', $formation->summary) }}</textarea>
              @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
              {{-- Durée --}}
              <div class="col-md-4 mb-3">
                <label for="duree" class="form-label">Durée</label>
                <input type="text"
                       name="duree"
                       id="duree"
                       class="form-control @error('duree') is-invalid @enderror"
                       value="{{ old('duree', $formation->duree) }}"
                       required>
                @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Lieu --}}
              <div class="col-md-4 mb-3">
                <label for="lieu" class="form-label">Lieu</label>
                <input type="text"
                       name="lieu"
                       id="lieu"
                       class="form-control @error('lieu') is-invalid @enderror"
                       value="{{ old('lieu', $formation->lieu) }}"
                       required>
                @error('lieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="row">
              {{-- Sessions --}}
              <div class="col-md-4 mb-3">
                <label for="sessions" class="form-label">Sessions</label>
                <select name="sessions"
                        id="sessions"
                        class="form-select @error('sessions') is-invalid @enderror"
                        required>
                  <option value="">-- Sélectionnez --</option>
                  @foreach([1,2,3] as $n)
                    <option value="{{ $n }}"
                      {{ old('sessions', $formation->sessions)==$n ? 'selected':'' }}>
                      {{ $n }}
                    </option>
                  @endforeach
                </select>
                @error('sessions')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Date limite --}}
              <div class="col-md-8 mb-3">
                <label for="deadline" class="form-label">Date limite</label>
                <input type="date"
                       name="deadline"
                       id="deadline"
                       class="form-control @error('deadline') is-invalid @enderror"
                       value="{{ old('deadline', $formation->deadline->format('Y-m-d')) }}"
                       min="{{ date('Y-m-d') }}"
                       required>
                @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Capacité --}}
              <div class="col-md-4 mb-3">
                <label for="capacite" class="form-label">Capacité</label>
                <input type="number"
                       name="capacite"
                       id="capacite"
                       class="form-control @error('capacite') is-invalid @enderror"
                       value="{{ old('capacite', $formation->capacite) }}"
                       min="1"
                       required>
                @error('capacite')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Date de début --}}
              <div class="col-md-8 mb-3">
                <label for="start_at" class="form-label">Date de début</label>
                <input type="date"
                       name="start_at"
                       id="start_at"
                       class="form-control @error('start_at') is-invalid @enderror"
                       value="{{ old('start_at', optional($formation->start_at)->format('Y-m-d')) }}"
                       required>
                @error('start_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            {{-- Mode --}}
            <div class="mb-3">
              <label for="mode" class="form-label">Mode</label>
              <select name="mode"
                      id="mode"
                      class="form-select @error('mode') is-invalid @enderror"
                      required>
                <option value="presentielle"
                  {{ old('mode', $formation->mode)=='presentielle'? 'selected':'' }}>
                  Présentielle
                </option>
                <option value="a_distance"
                  {{ old('mode', $formation->mode)=='a_distance'? 'selected':'' }}>
                  À distance
                </option>
              </select>
              @error('mode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Lien à distance --}}
            <div class="mb-3 d-none" id="link_field">
              <label for="link" class="form-label">Lien à distance</label>
              <input type="url"
                     name="link"
                     id="link"
                     class="form-control @error('link') is-invalid @enderror"
                     value="{{ old('link', $formation->link) }}">
              @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Formateur --}}
            <div class="mb-3">
              <label for="formateur" class="form-label">Formateur</label>
              <select name="formateur_id"
                      id="formateur"
                      class="form-select @error('formateur_id') is-invalid @enderror"
                      required>
                <option value="">-- Sélectionnez --</option>
                @foreach($formateurs as $f)
                  <option value="{{ $f->id }}"
                    {{ old('formateur_id', $formation->formateur_id)==$f->id ? 'selected':'' }}>
                    {{ $f->cin }} — {{ $f->prenom }} {{ $f->nom }}
                  </option>
                @endforeach
              </select>
              @error('formateur_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Grades --}}
            <div class="mb-3">
              <label class="form-label d-block">Grades concernés</label>
              @php
                $selected = old('grades', $formation->grades->pluck('id')->toArray());
              @endphp
              @foreach($grades as $grade)
                <div class="form-check form-check-inline">
                  <input class="form-check-input"
                         type="checkbox"
                         name="grades[]"
                         id="grade{{ $grade->id }}"
                         value="{{ $grade->id }}"
                         {{ in_array($grade->id, $selected) ? 'checked':'' }}>
                  <label class="form-check-label" for="grade{{ $grade->id }}">
                    {{ $grade->nom }}
                  </label>
                </div>
              @endforeach
              @error('grades')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>

          </div>
        </div>
      </div>
      <div class="col-lg-4"></div>
    </div>
  </form>
@endsection

@push('scripts')
  <!-- TinyMCE -->
  <script src="https://cdn.tiny.cloud/1/ecpdzputo2ujf94cdjincgez6pw1q7hh7vdaflsqjsok11v5/tinymce/7/tinymce.min.js"
          referrerpolicy="origin"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Init TinyMCE
      tinymce.init({
        selector: '#summary',
        plugins: 'link image lists table',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image'
      });

      // Show/hide link field
      var modeEl  = document.getElementById('mode'),
          linkDiv = document.getElementById('link_field');
      function toggleLink() {
        if (modeEl.value === 'a_distance') {
          linkDiv.classList.remove('d-none');
        } else {
          linkDiv.classList.add('d-none');
          document.getElementById('link').value = '';
        }
      }
      modeEl.addEventListener('change', toggleLink);
      toggleLink();

      // Enforce deadline ≥ today and start_at ≥ deadline
      var deadline = document.getElementById('deadline'),
          startAt  = document.getElementById('start_at'),
          today    = new Date().toISOString().split('T')[0];

      // Set min for deadline
      deadline.min = today;
      // Clamp any existing value
      if (deadline.value && deadline.value < today) {
        deadline.value = today;
      }

      function updateStartMin() {
        if (deadline.value) {
          startAt.min = deadline.value;
          if (startAt.value && startAt.value < deadline.value) {
            startAt.value = deadline.value;
          }
        } else {
          // if no deadline chosen yet, at least today
          startAt.min = today;
          if (startAt.value && startAt.value < today) {
            startAt.value = today;
          }
        }
      }

      // on deadline change
      deadline.addEventListener('change', function() {
        // clamp to today
        if (deadline.value < today) {
          deadline.value = today;
        }
        updateStartMin();
      });

      // initial enforce
      updateStartMin();
    });
  </script>
@endpush
