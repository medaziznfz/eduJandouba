@php
  $f = $formation ?? null;
@endphp

<div class="mb-3">
  <label for="titre" class="form-label">Titre</label>
  <input type="text" name="titre"
         class="form-control @error('titre') is-invalid @enderror"
         id="titre"
         value="{{ old('titre', $f->titre ?? '') }}">
  @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label for="thumbnail" class="form-label">Miniature</label>
  <input type="file" name="thumbnail"
         class="form-control @error('thumbnail') is-invalid @enderror"
         id="thumbnail" accept="image/*">
  @if($f && $f->thumbnail)
    <small>Actuelle : <a href="{{ asset('storage/'.$f->thumbnail) }}" target="_blank">voir</a></small>
  @endif
  @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label for="description" class="form-label">Description</label>
  <textarea name="description" rows="4"
            class="form-control @error('description') is-invalid @enderror"
            id="description">{{ old('description', $f->description ?? '') }}</textarea>
  @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <label for="duree" class="form-label">Durée</label>
    <input type="text" name="duree"
           class="form-control @error('duree') is-invalid @enderror"
           id="duree" placeholder="Ex : 3 mois"
           value="{{ old('duree', $f->duree ?? '') }}">
    @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4 mb-3">
    <label for="lieu" class="form-label">Lieu</label>
    <input type="text" name="lieu"
           class="form-control @error('lieu') is-invalid @enderror"
           id="lieu"
           value="{{ old('lieu', $f->lieu ?? '') }}">
    @error('lieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4 mb-3">
    <label for="capacite" class="form-label">Capacité</label>
    <input type="number" name="capacite" min="1"
           class="form-control @error('capacite') is-invalid @enderror"
           id="capacite"
           value="{{ old('capacite', $f->capacite ?? '') }}">
    @error('capacite')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <label for="sessions" class="form-label">Sessions</label>
    <select name="sessions"
            class="form-select @error('sessions') is-invalid @enderror"
            id="sessions">
      <option value="">-- Sélectionnez --</option>
      @for($i=1;$i<=3;$i++)
        <option value="{{ $i }}"
          {{ old('sessions', $f->sessions ?? '') == $i ? 'selected':'' }}>
          {{ $i }}
        </option>
      @endfor
    </select>
    @error('sessions')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-8 mb-3">
    <label for="deadline" class="form-label">Date limite d’inscription</label>
    <input type="date" name="deadline"
           class="form-control @error('deadline') is-invalid @enderror"
           id="deadline"
           value="{{ old('deadline', isset($f) ? \Carbon\Carbon::parse($f->deadline)->format('Y-m-d') : '') }}">
    @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="mb-3">
  <label class="form-label">Grades concernés</label>
  @foreach($grades as $grade)
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox"
             id="grade{{ $grade->id }}"
             name="grades[]" value="{{ $grade->id }}"
             {{ in_array($grade->id, old('grades', $f->grades->pluck('id')->toArray() ?? []))
                ? 'checked':'' }}>
      <label class="form-check-label" for="grade{{ $grade->id }}">
        {{ $grade->nom }}
      </label>
    </div>
  @endforeach
  @error('grades')<div class="text-danger">{{ $message }}</div>@enderror
</div>
