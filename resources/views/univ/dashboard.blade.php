@extends('layouts.app')

@section('content')

    <!-- Row with simplified Cards -->
    <div class="row">
        <!-- Card 1: View Formations -->
        <div class="col-xl-4">
            <div class="card card-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ri-folder-line display-6 text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="card-text"><span class="fw-medium">Voir les formations</span> disponibles pour vous inscrire.</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <a href="{{ route('univ.formations.index') }}" class="link-light">Voir les formations <i class="ri-arrow-right-s-line align-middle lh-1"></i></a>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->

        <!-- Card 2: Manage Applications -->
        <div class="col-xl-4">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ri-building-line display-6 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="card-text"><span class="fw-medium">Gérer les demandes</span> des utilisateurs pour les formations.</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <a href="{{ route('univ.applications.index') }}" class="link-light">Gérer les demandes <i class="ri-arrow-right-s-line align-middle lh-1"></i></a>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->

        <!-- Card 3: Create Formation -->
        <div class="col-xl-4">
            <div class="card card-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ri-add-line display-6 text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="card-text"><span class="fw-medium">Créer une formation</span> pour les utilisateurs.</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <a href="{{ route('univ.formations.create') }}" class="link-light">Créer une formation <i class="ri-arrow-right-s-line align-middle lh-1"></i></a>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->
    </div> <!-- end row-->

@endsection
