@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- titre et fil d’Ariane --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent p-3 rounded">
                <h4 class="mb-sm-0">Liste des Formations</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Formations</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- recherche et filtre --}}
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

    {{-- grille des formations --}}
    <div class="row" id="formationsContainer">
        @foreach($formations as $formation)
        <div class="col-xxl-3 col-sm-6 mb-4 formation-card"
             data-created="{{ $formation->created_at->toDateString() }}">
            <div class="card card-height-100">
                <div class="card-body d-flex flex-column h-100">

                    {{-- en-tête --}}
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

                    {{-- contenu --}}
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
                                @if($formation->mode === 'a_distance' && $formation->link)
                                <li>
                                    <strong>Lien :</strong>
                                    <a href="{{ $formation->link }}" target="_blank" class="link-primary">
                                        {{ Str::limit($formation->link, 30) }}
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    {{-- progression --}}
                    <div class="mt-auto">
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1">Places inscrites</div>
                            <div class="flex-shrink-0">{{ $formation->nbre_inscrit }}/{{ $formation->capacite }}</div>
                        </div>
                        @php
                            $pct = $formation->capacite
                                ? round($formation->nbre_inscrit * 100 / $formation->capacite)
                                : 0;
                        @endphp
                        <div class="progress progress-sm animated-progress">
                            <div class="progress-bar bg-success"
                                 role="progressbar"
                                 style="width: {{ $pct }}%;"
                                 aria-valuenow="{{ $pct }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- footer --}}
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

                    {{-- Add Start at field below Date limite --}}
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

    {{-- pagination --}}
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
document.addEventListener('DOMContentLoaded', function(){
    if (window.feather) feather.replace();

    // bornes de date
    const now        = new Date();
    const today      = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const dow        = today.getDay(); // 0=dimanche
    const monday     = new Date(today);
    monday.setDate(today.getDate() - ((dow + 6) % 7));
    const startWeek  = new Date(monday.getFullYear(), monday.getMonth(), monday.getDate());
    const startMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    const startYear  = new Date(today.getFullYear(), 0, 1);

    function parseYMD(str) {
        const [y, m, d] = str.split('-').map(Number);
        return new Date(y, m - 1, d);
    }

    const cards = document.querySelectorAll('.formation-card');

    // Filtre sur created_at
    document.getElementById('dateFilter').addEventListener('change', function(){
        const val = this.value;
        cards.forEach(card => {
            const dt = parseYMD(card.dataset.created);
            let show = false;
            switch(val) {
                case 'today':
                    show = dt.getTime() === today.getTime();
                    break;
                case 'week':
                    show = dt >= startWeek && dt <= today;
                    break;
                case 'month':
                    show = dt >= startMonth && dt <= today;
                    break;
                case 'year':
                    show = dt >= startYear && dt <= today;
                    break;
                default:
                    show = true;
            }
            card.style.display = show ? '' : 'none';
        });
    });

    // Recherche textuelle
    document.getElementById('searchInput').addEventListener('input', function(){
        const q = this.value.trim().toLowerCase();
        cards.forEach(card => {
            const title = card.querySelector('h5 a').textContent.toLowerCase();
            card.style.display = title.includes(q) ? '' : 'none';
        });
    });
});
</script>
@endpush
