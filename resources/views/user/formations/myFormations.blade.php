@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Title and Breadcrumb --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent p-3 rounded">
                <h4 class="mb-sm-0">Mes Formations</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Mes Formations</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Formations List --}}
    <div class="row" id="formationsContainer">
        @foreach($formations as $applicationRequest)
            @if($applicationRequest->formation) {{-- Check if formation exists --}}
            <div class="col-xxl-3 col-sm-6 mb-4 formation-card">
                <div class="card card-height-100">
                    <div class="card-body d-flex flex-column h-100">

                        {{-- Formation Header --}}
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0">
                                    Créé {{ $applicationRequest->formation->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        {{-- Formation Content --}}
                        <div class="d-flex mb-3">
                            @if($applicationRequest->formation->thumbnail)
                                <img src="{{ asset('storage/'.$applicationRequest->formation->thumbnail) }}"
                                     alt="Vignette" class="rounded me-3"
                                     style="width:60px;height:60px;object-fit:cover">
                            @else
                                <div class="bg-secondary-subtle rounded me-3"
                                     style="width:60px;height:60px;"></div>
                            @endif
                            <div class="flex-grow-1">
                                <h5 class="mb-1 fs-15">
                                    <a href="{{ route('user.formations.show', $applicationRequest->formation) }}" class="text-body">
                                        {{ $applicationRequest->formation->titre }}
                                    </a>
                                </h5>
                                <p class="text-muted mb-2">{{ Str::limit($applicationRequest->formation->description, 60) }}</p>
                            </div>
                        </div>

                        {{-- Application Status --}}
                        <div class="mt-auto">
                            <p class="mb-2"><strong>Status de la demande :</strong></p>
                            <span class="badge bg-info">
                                {{ $statusLabels[$applicationRequest->pivot->status] ?? 'Non défini' }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            @endif {{-- End check for null formation --}}
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="row g-0 text-center text-sm-start align-items-center mb-4">
        <div class="col-sm-6">
            <p class="mb-sm-0 text-muted">
                Affichage <span class="fw-semibold">{{ $formations->firstItem() }}</span> à
                <span class="fw-semibold">{{ $formations->lastItem() }}</span> sur
                <span class="fw-semibold">{{ $formations->total() }}</span> entrées
            </p>
        </div>
        <div class="col-sm-6">
            <ul class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                <li class="page-item{{ $formations->onFirstPage() ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $formations->previousPageUrl() ?? '#' }}">Previous</a>
                </li>
                @for ($i = 1; $i <= $formations->lastPage(); $i++)
                    <li class="page-item{{ $formations->currentPage() == $i ? ' active' : '' }}">
                        <a class="page-link" href="{{ $formations->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item{{ !$formations->hasMorePages() ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $formations->nextPageUrl() ?? '#' }}">Next</a>
                </li>
            </ul>
        </div>
    </div>

</div>
@endsection
