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

  <form action="{{ route('univ.formations.update', $formation) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PATCH')
    <div class="row">
      <div class="col-lg-8">
        <div class="card mb-4"><div class="card-body">

          {{-- Titre --}}
          <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre"
                   class="form-control @error('titre') is-invalid @enderror"
                   value="{{ old('titre', $formation->titre) }}">
            @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Miniature --}}
          <div class="mb-3">
            <label for="thumbnail" class="form-label">Miniature</label>
            <input type="file" name="thumbnail" id="thumbnail"
                   class="form-control @error('thumbnail') is-invalid @enderror"
                   accept="image/*">
            @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
            @if($formation->thumbnail)
              <img src="{{ asset('storage/'.$formation->thumbnail) }}"
                   class="mt-2" style="max-height:100px;">
            @endif
          </div>

          {{-- Description --}}
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $formation->description) }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Résumé --}}
          <div class="mb-3">
            <label for="summary" class="form-label">Résumé (HTML)</label>
            <textarea name="summary" id="summary" rows="6"
                      class="form-control @error('summary') is-invalid @enderror">{{ old('summary', $formation->summary) }}</textarea>
            @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="row">
            {{-- Durée --}}
            <div class="col-md-4 mb-3">
              <label for="duree" class="form-label">Durée</label>
              <input type="text" name="duree" id="duree"
                     class="form-control @error('duree') is-invalid @enderror"
                     value="{{ old('duree', $formation->duree) }}">
              @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            {{-- Lieu --}}
            <div class="col-md-4 mb-3">
              <label for="lieu" class="form-label">Lieu</label>
              <input type="text" name="lieu" id="lieu"
                     class="form-control @error('lieu') is-invalid @enderror"
                     value="{{ old('lieu', $formation->lieu) }}">
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
                @foreach([1,2,3] as $n)
                  <option value="{{ $n }}"
                    {{ old('sessions', $formation->sessions)==$n? 'selected':'' }}>
                    {{ $n }}
                  </option>
                @endforeach
              </select>
              @error('sessions')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            {{-- Date limite --}}
            <div class="col-md-8 mb-3">
              <label for="deadline" class="form-label">Date limite</label>
              <input type="date" name="deadline" id="deadline"
                     class="form-control @error('deadline') is-invalid @enderror"
                     value="{{ old('deadline', $formation->deadline->format('Y-m-d')) }}">
              @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            {{-- Capacité --}}
            <div class="col-md-4 mb-3">
              <label for="capacite" class="form-label">Capacité</label>
              <input type="number" name="capacite" id="capacite" min="1"
                     class="form-control @error('capacite') is-invalid @enderror"
                     value="{{ old('capacite', $formation->capacite) }}">
              @error('capacite')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            {{-- Date de début --}}
            <div class="col-md-8 mb-3">
              <label for="start_at" class="form-label">Date de début</label>
              <input type="date" name="start_at" id="start_at"
                    class="form-control @error('start_at') is-invalid @enderror"
                    value="{{ old('start_at', $formation->start_at ? \Carbon\Carbon::parse($formation->start_at)->format('Y-m-d') : '') }}">
              @error('start_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          {{-- Mode --}}
          <div class="mb-3">
            <label for="mode" class="form-label">Mode</label>
            <select name="mode" id="mode"
                    class="form-select @error('mode') is-invalid @enderror">
              <option value="presentielle" {{ old('mode', $formation->mode)=='presentielle'? 'selected':'' }}>Présentielle</option>
              <option value="a_distance"   {{ old('mode', $formation->mode)=='a_distance'?   'selected':'' }}>À distance</option>
            </select>
            @error('mode')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Lien à distance --}}
          <div class="mb-3 d-none" id="link_field">
            <label for="link" class="form-label">Lien à distance</label>
            <input type="url" name="link" id="link"
                   class="form-control @error('link') is-invalid @enderror"
                   value="{{ old('link', $formation->link) }}">
            @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Grades --}}
          <div class="mb-3">
            <label class="form-label d-block">Grades concernés</label>
            @php $sel = old('grades', $formation->grades->pluck('id')->toArray()); @endphp
            @foreach($grades as $grade)
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox"
                       id="grade{{ $grade->id }}" name="grades[]"
                       value="{{ $grade->id }}"
                       {{ in_array($grade->id, $sel)? 'checked':'' }}>
                <label class="form-check-label" for="grade{{ $grade->id }}">{{ $grade->nom }}</label>
              </div>
            @endforeach
            @error('grades')<div class="text-danger mt-1">{{ $message }}</div>@enderror
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-success">Enregistrer</button>
          </div>

        </div></div>
      </div>
      <div class="col-lg-4"></div>
    </div>
  </form>
@endsection

@push('scripts')
  <script src="https://cdn.tiny.cloud/1/ecpdzputo2ujf94cdjincgez6pw1q7hh7vdaflsqjsok11v5/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      tinymce.init({
        selector: '#summary',
        plugins: [
          'anchor autolink charmap codesample emoticons image link lists media '+
          'searchreplace table visualblocks wordcount '+
          'checklist mediaembed casechange formatpainter pageembed a11ychecker '+
          'tinymcespellchecker permanentpen powerpaste advtable advcode editimage '+
          'advtemplate ai mentions tinycomments tableofcontents footnotes mergetags '+
          'autocorrect typography inlinecss markdown importword exportword exportpdf'
        ],
        toolbar:
          'undo redo | blocks fontfamily fontsize | '+
          'bold italic underline strikethrough | link image media table mergetags | '+
          'addcomment showcomments | spellcheckdialog a11ycheck typography | '+
          'align lineheight | checklist numlist bullist indent outdent | '+
          'emoticons charmap | removeformat',
        tinycomments_mode:  'embedded',
        tinycomments_author:'{{ Auth::user()->name ?? "Auteur" }}',
        mergetags_list: [
          { value:'First.Name', title:'First Name' },
          { value:'Email',      title:'Email'      },
        ],
        ai_request: (req, respondWith) =>
          respondWith.string(()=>
            Promise.reject('See docs to implement AI Assistant')
          )
      });

      const modeEl  = document.getElementById('mode'),
            linkDiv = document.getElementById('link_field');
      function toggleLink(){
        if(modeEl.value==='a_distance'){
          linkDiv.classList.remove('d-none');
        } else {
          linkDiv.classList.add('d-none');
          document.getElementById('link').value = '';
        }
      }
      modeEl.addEventListener('change', toggleLink);
      toggleLink();
    });
  </script>
@endpush
