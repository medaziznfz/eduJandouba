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

    {{-- Search and Filter --}}
    <div class="row g-4 mb-3">
        <div class="col-sm">
            <div class="d-flex justify-content-sm-end gap-2">
                <div class="search-box ms-2">
                    <input type="text" id="searchInput" class="form-control" placeholder="Recherche...">
                    <i class="ri-search-line search-icon"></i>
                </div>
                <select id="dateFilter" class="form-control w-md">
                    <option value="all">Toutes</option>
                    <option value="today">Aujourd’hui</option>
                    <option value="week">Cette semaine</option>
                    <option value="month">Ce mois-ci</option>
                    <option value="year">Cette année</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Formations Grid --}}
    <div class="row" id="formationsContainer">
        @foreach($formations as $formation)
        <div class="col-xxl-3 col-sm-6 mb-4 formation-card"
             data-created="{{ $formation->created_at->toDateString() }}">
            <div class="card card-height-100">
                <div class="card-body d-flex flex-column h-100">

                    {{-- Header --}}
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0">
                                Créé {{ $formation->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-1" data-bs-toggle="dropdown">
                                    <i data-feather="more-horizontal" class="icon-sm"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item"
                                       href="{{ route('user.formations.show', $formation) }}">
                                        <i class="ri-eye-fill align-bottom me-2"></i> Voir
                                    </a>
                                    <a class="dropdown-item"
                                       href="{{ route('user.formations.show', $formation) }}?tab=inscrire">
                                        <i class="ri-pencil-fill align-bottom me-2"></i> S’inscrire
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="d-flex mb-3">
                        @if($formation->thumbnail)
                        <img src="{{ asset('storage/'.$formation->thumbnail) }}"
                             alt="Vignette" class="rounded me-3"
                             style="width:60px;height:60px;object-fit:cover">
                        @else
                        <div class="bg-secondary-subtle rounded me-3"
                             style="width:60px;height:60px;"></div>
                        @endif
                        <div class="flex-grow-1">
                            <h5 class="mb-1 fs-15">
                                <a href="{{ route('user.formations.show', $formation) }}" class="text-body">
                                    {{ $formation->titre }}
                                </a>
                            </h5>
                            <p class="text-muted mb-2">{{ Str::limit($formation->description, 60) }}</p>
                            <ul class="list-unstyled small text-muted mb-0">
                                <li>
                                    <strong>Mode :</strong>
                                    {{ $formation->mode === 'a_distance' ? 'À distance' : 'Présentiel' }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Application Status --}}
                    @php
                        $reqStatus = $formation->pivot->status;
                        $badgeClasses = [
                            0 => 'bg-info',     // En attente
                            1 => 'bg-success',  // Acceptée
                            2 => 'bg-danger',   // Refusée
                            3 => 'bg-warning',  // Liste d’attente
                            4 => 'bg-primary',  // Confirmée
                        ];
                    @endphp

                    <div class="mt-auto">
                        <p class="mb-2"><strong>Status de la demande :</strong></p>
                        <span class="badge {{ $badgeClasses[$reqStatus] ?? 'bg-secondary' }}">
                            {{ $statusLabels[$reqStatus] ?? '—' }}
                        </span>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="card-footer bg-transparent border-top-dashed py-2">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="badge fs-12 {{ $formation->status_class }}">
                                {{ $formation->status_label }}
                            </span>
                        </div>
                        <div class="flex-shrink-0 text-muted">
                            <i class="ri-calendar-event-fill me-1"></i>
                            Deadline : {{ $formation->deadline->format('d M, Y') }}
                        </div>
                    </div>

                    {{-- Start date field --}}
                    <div class="d-flex align-items-center mt-2">
                        <div class="flex-shrink-0 text-muted">
                            <i class="ri-calendar-fill me-1"></i>
                            Date de début : {{ $formation->start_at ? \Carbon\Carbon::parse($formation->start_at)->format('d M, Y') : 'Non défini' }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
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
                    <li class="page-item{{ $formations->currentPage()==$i ? ' active' : '' }}">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.feather) feather.replace();

    // Apply filters (date filter and search)
    const cards = document.querySelectorAll('.formation-card');

    // Filter by created_at
    document.getElementById('dateFilter').addEventListener('change', function() {
        const val = this.value;
        cards.forEach(card => {
            const dt = new Date(card.dataset.created);
            let show = false;
            switch (val) {
                case 'today':
                    show = dt.toDateString() === new Date().toDateString();
                    break;
                case 'week':
                    show = dt >= new Date(new Date().setDate(new Date().getDate() - 7));
                    break;
                case 'month':
                    show = dt >= new Date(new Date().setMonth(new Date().getMonth() - 1));
                    break;
                case 'year':
                    show = dt >= new Date(new Date().setFullYear(new Date().getFullYear() - 1));
                    break;
                default:
                    show = true;
            }
            card.style.display = show ? '' : 'none';
        });
    });

    // Search filter
    document.getElementById('searchInput').addEventListener('input', function() {
        const q = this.value.trim().toLowerCase();
        cards.forEach(card => {
            const title = card.querySelector('h5 a').textContent.toLowerCase();
            card.style.display = title.includes(q) ? '' : 'none';
        });
    });
});
</script>
@endpush
