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
        <div class="card mb-4"><div class="card-body">

          {{-- Titre --}}
          <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre"
                   class="form-control @error('titre') is-invalid @enderror"
                   value="{{ old('titre') }}">
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
                     value="{{ old('duree') }}">
              @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            {{-- Lieu --}}
            <div class="col-md-4 mb-3">
              <label for="lieu" class="form-label">Lieu</label>
              <input type="text" name="lieu" id="lieu" placeholder="Ville / Établissement"
                     class="form-control @error('lieu') is-invalid @enderror"
                     value="{{ old('lieu') }}">
              @error('lieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
          </div>

          <div class="row">
            {{-- Sessions --}}
            <div class="col-md-4 mb-3">
              <label for="sessions" class="form-label">Sessions</label>
              <select name="sessions" id="sessions"
                      class="form-select @error('sessions') is-invalid @enderror">
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
                     value="{{ old('deadline') }}">
              @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            {{-- Capacité --}}
            <div class="col-md-4 mb-3">
              <label for="capacite" class="form-label">Capacité</label>
              <input type="number" name="capacite" id="capacite" min="1"
                     class="form-control @error('capacite') is-invalid @enderror"
                     value="{{ old('capacite') }}">
              @error('capacite')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            {{-- Date de début --}}  
            <div class="col-md-8 mb-3">
              <label for="start_at" class="form-label">Date de début</label>
              <input type="date" name="start_at" id="start_at"
                    class="form-control @error('start_at') is-invalid @enderror"
                    value="{{ old('start_at') }}">
              @error('start_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

          </div>

          {{-- Mode --}}
          <div class="mb-3">
            <label for="mode" class="form-label">Mode</label>
            <select name="mode" id="mode"
                    class="form-select @error('mode') is-invalid @enderror">
              <option value="presentielle" {{ old('mode')=='presentielle'? 'selected':'' }}>Présentielle</option>
              <option value="a_distance"   {{ old('mode')=='a_distance'?   'selected':'' }}>À distance</option>
            </select>
            @error('mode')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Lien à distance --}}
          <div class="mb-3 d-none" id="link_field">
            <label for="link" class="form-label">Lien à distance</label>
            <input type="url" name="link" id="link"
                   class="form-control @error('link') is-invalid @enderror"
                   value="{{ old('link') }}">
            @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Grades --}}
          <div class="mb-3">
            <label class="form-label d-block">Grades concernés</label>
            @foreach($grades as $grade)
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox"
                       id="grade{{ $grade->id }}" name="grades[]"
                       value="{{ $grade->id }}"
                       {{ in_array($grade->id, old('grades', []))? 'checked':'' }}>
                <label class="form-check-label" for="grade{{ $grade->id }}">{{ $grade->nom }}</label>
              </div>
            @endforeach
            @error('grades')<div class="text-danger mt-1">{{ $message }}</div>@enderror
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-success">Créer</button>
          </div>

        </div></div>
      </div>
      <div class="col-lg-4"></div>
    </div>
  </form>
@endsection

@push('scripts')
  <!-- TinyMCE v7 (no-API-key prompt) -->
  <script src="https://cdn.tiny.cloud/1/ecpdzputo2ujf94cdjincgez6pw1q7hh7vdaflsqjsok11v5/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
    tinymce.init({
      selector: '#summary',
      plugins: [
        'anchor autolink charmap codesample emoticons image link lists media ' +
        'searchreplace table visualblocks wordcount ' +
        'checklist mediaembed casechange formatpainter pageembed a11ychecker ' +
        'tinymcespellchecker permanentpen powerpaste advtable advcode editimage ' +
        'advtemplate ai mentions tinycomments tableofcontents footnotes mergetags ' +
        'autocorrect typography inlinecss markdown importword exportword exportpdf'
      ],
      toolbar:
        'undo redo | blocks fontfamily fontsize | ' +
        'bold italic underline strikethrough | link image media table mergetags | ' +
        'addcomment showcomments | spellcheckdialog a11ycheck typography | ' +
        'align lineheight | checklist numlist bullist indent outdent | ' +
        'emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: '{{ Auth::user()->name ?? "Auteur" }}',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
      ai_request: (req, respondWith) =>
        respondWith.string(() =>
          Promise.reject('See docs to implement AI Assistant')
        )
    });

    const modeEl = document.getElementById('mode'),
          linkDiv = document.getElementById('link_field');  // link field container

    // Initially hide the link field and set its value to null
    linkDiv.classList.add('d-none');
    document.getElementById('link').value = '';

    // Listen for changes to the mode
    modeEl.addEventListener('change', function() {
      // When the mode is 'a_distance', we just hide the link field
      linkDiv.classList.add('d-none');
      document.getElementById('link').value = ''; // Make sure it's empty
    });

    // Ensure the field is never shown and always empty
    // No need for any other toggling logic here
  });

  </script>
@endpush
