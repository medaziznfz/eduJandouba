@extends('layouts.app')

@push('styles')
    <!-- Ajoutez ici vos styles spécifiques si besoin -->
@endpush

@section('content')

    <!-- Dashboard spécifique utilisateur -->
    <div class="row">
        <!-- Card for "Mes demandes d'inscription" -->
        <div class="col-xl-4">
            <div class="card card-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ri-file-search-line text-info fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="card-text"><span class="fw-medium">Mes formations</span></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <a href="{{ route('forma.formations.index') }}" class="link-info">Voir mes formations<i class="ri-arrow-right-s-line align-middle lh-1"></i></a>
                    </div>
                </div>
            </div>
        </div><!-- end col -->


    </div><!-- end row -->

@endsection

@push('scripts')
    <!-- Ajoutez ici vos scripts spécifiques si besoin -->
@endpush
