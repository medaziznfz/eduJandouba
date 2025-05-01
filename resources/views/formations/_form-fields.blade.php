<div class="mb-3">
  <label class="form-label">Titre</label>
  <input name="titre" class="form-control @error('titre') is-invalid @enderror"
         value="{{ old('titre', $formation->titre ?? '') }}">
  @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label class="form-label">Miniature</label>
  <input name="thumbnail" type="file"
         class="form-control @error('thumbnail') is-invalid @enderror">
  @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
  @if(isset($formation) && $formation->thumbnail)
    <img src="{{ asset('storage/'.$formation->thumbnail) }}"
         class="mt-2" width="100">
  @endif
</div>

<div class="mb-3">
  <label class="form-label">Description</label>
  <textarea name="description" rows="4"
            class="form-control @error('description') is-invalid @enderror">{{ old('description', $formation->description ?? '') }}</textarea>
  @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <label class="form-label">Durée</label>
    <input name="duree" class="form-control @error('duree') is-invalid @enderror"
           value="{{ old('duree', $formation->duree ?? '') }}">
    @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4 mb-3">
    <label class="form-label">Lieu</label>
    <input name="lieu" class="form-control @error('lieu') is-invalid @enderror"
           value="{{ old('lieu', $formation->lieu ?? '') }}">
    @error('lieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4 mb-3">
    <label class="form-label">Capacité</label>
    <input name="capacite" type="number" min="1"
           class="form-control @error('capacite') is-invalid @enderror"
           value="{{ old('capacite', $formation->capacite ?? '') }}">
    @error('capacite')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <label class="form-label">Sessions</label>
    <select name="sessions" class="form-select @error('sessions') is-invalid @enderror">
      <option value="">-- Sélectionnez --</option>
      @foreach([1,2,3] as $n)
        <option value="{{ $n }}" {{ old('sessions', $formation->sessions ?? '') == $n ? 'selected':'' }}>
          {{ $n }}
        </option>
      @endforeach
    </select>
    @error('sessions')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-8 mb-3">
    <label class="form-label">Date limite</label>
    <input name="deadline" id="deadline" type="text"
           class="form-control @error('deadline') is-invalid @enderror"
           value="{{ old('deadline', isset($formation) ? $formation->deadline->format('Y-m-d') : '') }}">
    @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="mb-3">
  <label class="form-label">Grades concernés</label><br>
  @foreach($grades as $grade)
    <div class="form-check form-check-inline">
      <input name="grades[]" type="checkbox"
             class="form-check-input"
             value="{{ $grade->id }}"
             {{ in_array($grade->id, old('grades', $formation->grades->pluck('id')->toArray() ?? []))?'checked':'' }}>
      <label class="form-check-label">{{ $grade->nom }}</label>
    </div>
  @endforeach
  @error('grades')<div class="text-danger">{{ $message }}</div>@enderror
</div>
