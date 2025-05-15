@extends('layouts.app')

@section('content')
<!-- Cover Photo Section -->
<div class="position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg profile-setting-img">
        <img src="assets/images/profile-bg.jpg" class="profile-wid-img" alt="">
        <div class="overlay-content">
            <div class="text-end p-3">
                
            </div>
        </div>
    </div>
</div>

<!-- Profile Details Section -->
<div class="row">
    <div class="col-xxl-3">
        <div class="card mt-n5">
            <div class="card-body p-4">
                <div class="text-center">
                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                        <img src="assets/images/users/avatar-1.jpg" class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow" alt="user-profile-image">
                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                            <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                <span class="avatar-title rounded-circle bg-light text-body material-shadow">
                                    <i class="ri-camera-fill"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                    <h5 class="fs-16 mb-1">{{ $user->prenom }} {{ $user->nom }}</h5>
                    <p class="text-muted mb-0">{{ $user->role }}</p> <!-- Display user role -->
                </div>
            </div>
        </div>
        <!--end card-->
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-5">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Complétez votre profil</h5>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="javascript:void(0);" class="badge bg-light text-primary fs-12" id="editProfileBtn">
                            <i class="ri-edit-box-line align-bottom me-1"></i> Modifier
                        </a>
                    </div>
                </div>
                <div class="progress animated-progress custom-progress progress-label">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        <div class="label">100%</div>
                    </div>
                </div>
                <!-- Show the CIN and Etablissement details as text -->
                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <strong>CIN:</strong>
                        <span>{{ $user->cin }}</span>
                    </div>

                    <!-- Only show Etablissement if it is not null -->
                    @if($user->etablissement)
                        <div class="d-flex justify-content-between">
                            <strong>Etablissement:</strong>
                            <span>{{ $user->etablissement->nom }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->

    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                            <i class="fas fa-home"></i> Détails personnels
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                            <i class="far fa-user"></i> Modifier le mot de passe
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                        <form action="{{ route('profile.update') }}" method="POST" id="updateProfileForm">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="prenom" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="nom" class="form-label">Nom</label>
                                        <input type="text" class="form-control" name="nom" value="{{ old('nom', $user->nom) }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Adresse Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Numéro de téléphone</label>
                                        <input type="text" class="form-control" name="telephone" value="{{ old('telephone', $user->telephone) }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="changePassword" role="tabpanel">
                        <form action="{{ route('profile.password.update') }}" method="POST" id="updatePasswordForm">
                            @csrf
                            <div class="row g-2">
                                <div class="col-lg-4">
                                    <div>
                                        <label for="oldpassword" class="form-label">Ancien mot de passe*</label>
                                        <input type="password" class="form-control" name="old_password" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="newpassword" class="form-label">Nouveau mot de passe*</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="confirmpassword" class="form-label">Confirmer le mot de passe*</label>
                                        <input type="password" class="form-control" name="new_password_confirmation" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-success">Changer le mot de passe</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Show SweetAlert only after the form submission and page reload
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endpush
