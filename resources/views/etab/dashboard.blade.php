@extends('layouts.app')

@push('styles')
    <!-- Ajoutez ici vos styles spécifiques si besoin -->
@endpush

@section('content')

    <!-- Dashboard spécifique validateur établissement -->
    <div class="row">
        <!-- Card for "Valider les demandes d'inscription" -->
        <div class="col-xl-6">
            <div class="card card-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ri-file-search-line text-success fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="card-text"><span class="fw-medium">Valider les demandes d'inscription</span></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <a href="{{ route('etab.requests') }}" class="link-success">Voir les demandes <i class="ri-arrow-right-s-line align-middle lh-1"></i></a>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

        <!-- Card for "Valider les demandes de participation" -->
        <div class="col-xl-6">
            <div class="card card-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ri-user-line text-info fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="card-text"><span class="fw-medium">Valider les demandes de participation</span></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <a href="{{ route('etab.applications.index') }}" class="link-info">Voir les participations <i class="ri-arrow-right-s-line align-middle lh-1"></i></a>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

    </div><!-- end row -->

@endsection

@push('scripts')
    <!-- Ajoutez ici vos scripts spécifiques si besoin -->
@endpush
