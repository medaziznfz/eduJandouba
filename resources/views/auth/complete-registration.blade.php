<!doctype html>
<html lang="fr"
      data-layout="vertical"
      data-topbar="light"
      data-sidebar="dark"
      data-sidebar-size="lg"
      data-sidebar-image="none"
      data-preloader="disable"
      data-theme="default"
      data-theme-colors="default">
<head>
    <meta charset="utf-8" />
    <title>Compléter votre inscription | ONPC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}"        rel="stylesheet" />
    <link href="{{ asset('assets/css/icons.min.css') }}"           rel="stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}"             rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.min.css') }}"          rel="stylesheet" />
</head>

<body>
    <div class="auth-page-wrapper pt-5">
        <!-- fond & overlay identique à vos autres pages auth -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120"><path d="M0,36 C144,53.6 432,123.2 720,124 C1008,124.8 1296,56.8 1440,40 L1440 140 L0 140Z"></path></svg>
            </div>
        </div>

        <div class="auth-page-content">
            <div class="container">
                <!-- Logo et titre -->
                <div class="row">
                    <div class="col-lg-12 text-center mt-sm-5 mb-4 text-white-50">
                        <a href="#" class="d-inline-block auth-logo">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="20">
                        </a>
                        <p class="mt-3 fs-15 fw-medium">Complétez votre inscription ONPC</p>
                    </div>
                </div>

                <!-- Formulaire -->
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Finalisez votre compte</h5>
                                    <p class="text-muted">Entrez votre téléphone et mot de passe</p>
                                </div>

                                <div class="p-2 mt-4">
                                    {{-- Affichage des erreurs --}}
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $e)
                                                    <li>{{ $e }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST"
                                          action="{{ route('registration.submit', $demande->confirmation_token) }}"
                                          class="needs-validation" novalidate>
                                        @csrf

                                        {{-- Chiffres pré-remplis, readonly --}}
                                        <div class="mb-3">
                                            <label class="form-label">Prénom</label>
                                            <input type="text" class="form-control" value="{{ $demande->prenom }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nom</label>
                                            <input type="text" class="form-control" value="{{ $demande->nom }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Adresse email</label>
                                            <input type="email" class="form-control" value="{{ $demande->email }}" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">CIN</label>
                                            <input type="text" class="form-control" value="{{ $demande->cin }}" readonly>
                                        </div>

                                        {{-- Nouveau champ Téléphone --}}
                                        <div class="mb-3">
                                            <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="telephone"
                                                   name="telephone"
                                                   placeholder="Entrez votre numéro de téléphone"
                                                   required>
                                            <div class="invalid-feedback">
                                                Veuillez renseigner votre téléphone.
                                            </div>
                                        </div>

                                        {{-- Mot de passe --}}
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                            <input type="password"
                                                   class="form-control"
                                                   id="password"
                                                   name="password"
                                                   placeholder="Entrez un mot de passe"
                                                   required>
                                            <div class="invalid-feedback">
                                                Veuillez renseigner un mot de passe.
                                            </div>
                                        </div>

                                        {{-- Confirmation --}}
                                        <div class="mb-4">
                                            <label for="password_confirmation" class="form-label">Confirmer mot de passe <span class="text-danger">*</span></label>
                                            <input type="password"
                                                   class="form-control"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   placeholder="Confirmez le mot de passe"
                                                   required>
                                            <div class="invalid-feedback">
                                                Les mots de passe doivent correspondre.
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">
                                                Créer mon compte
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="mb-0 text-muted">
                            &copy; <script>document.write(new Date().getFullYear())</script> ONPC. Tous droits réservés.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.auth-page-wrapper -->

    <!-- JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
</body>
</html>
