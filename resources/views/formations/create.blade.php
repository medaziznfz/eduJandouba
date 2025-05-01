@extends('layouts.app')

@section('content')
  <!-- Page title + breadcrumb -->
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
      <!-- Left column: main fields -->
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
                     value="{{ old('titre') }}">
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
            </div>

            {{-- Description --}}
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea name="description"
                        id="description"
                        rows="4"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
              {{-- Durée --}}
              <div class="col-md-4 mb-3">
                <label for="duree" class="form-label">Durée</label>
                <input type="text"
                       name="duree"
                       id="duree"
                       placeholder="Ex : 3 mois"
                       class="form-control @error('duree') is-invalid @enderror"
                       value="{{ old('duree') }}">
                @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Lieu --}}
              <div class="col-md-4 mb-3">
                <label for="lieu" class="form-label">Lieu</label>
                <input type="text"
                       name="lieu"
                       id="lieu"
                       placeholder="Ville / Établissement"
                       class="form-control @error('lieu') is-invalid @enderror"
                       value="{{ old('lieu') }}">
                @error('lieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Capacité --}}
              <div class="col-md-4 mb-3">
                <label for="capacite" class="form-label">Capacité</label>
                <input type="number"
                       name="capacite"
                       id="capacite"
                       min="1"
                       class="form-control @error('capacite') is-invalid @enderror"
                       value="{{ old('capacite') }}">
                @error('capacite')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="row">
              {{-- Sessions --}}
              <div class="col-md-4 mb-3">
                <label for="sessions" class="form-label">Sessions</label>
                <select name="sessions"
                        id="sessions"
                        class="form-select @error('sessions') is-invalid @enderror">
                  <option value="">-- Sélectionnez --</option>
                  <option value="1" {{ old('sessions')=='1' ? 'selected' : '' }}>1</option>
                  <option value="2" {{ old('sessions')=='2' ? 'selected' : '' }}>2</option>
                  <option value="3" {{ old('sessions')=='3' ? 'selected' : '' }}>3</option>
                </select>
                @error('sessions')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              {{-- Deadline (native date picker) --}}
              <div class="col-md-8 mb-3">
                <label for="deadline" class="form-label">Date limite d’inscription</label>
                <input type="date"
                       name="deadline"
                       id="deadline"
                       class="form-control @error('deadline') is-invalid @enderror"
                       value="{{ old('deadline') }}">
                @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            {{-- Grades concernés --}}
            <div class="mb-3">
              <label class="form-label d-block">Grades concernés</label>
              @foreach($grades as $grade)
                <div class="form-check form-check-inline">
                  <input class="form-check-input"
                         type="checkbox"
                         id="grade{{ $grade->id }}"
                         name="grades[]"
                         value="{{ $grade->id }}"
                         {{ in_array($grade->id, old('grades', [])) ? 'checked' : '' }}>
                  <label class="form-check-label" for="grade{{ $grade->id }}">
                    {{ $grade->nom }}
                  </label>
                </div>
              @endforeach
              @error('grades')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-success">Créer</button>
            </div>

          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </div><!-- /.col-lg-8 -->

      <!-- right col (empty or sidebar) -->
      <div class="col-lg-4"></div>
    </div><!-- /.row -->
  </form>
@endsection
