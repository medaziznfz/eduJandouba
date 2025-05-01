<!doctype html>
<html lang="fr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Connexion | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Connexion au tableau de bord ONPC" name="description" />
    <meta content="ONPC" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="auth-page-wrapper pt-5">
        <!-- Background -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="#" class="d-inline-block auth-logo">
                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo" height="50">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Connexion à l’espace Jandouba</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Bienvenue !</h5>
                                    <p class="text-muted">Veuillez vous connecter à votre compte</p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        {{ $errors->first() }}
                                    </div>
                                @endif

                                <div class="p-2 mt-4">
                                    <form method="POST" action="{{ route('login.submit') }}">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="identifiant" class="form-label">Email / CIN / Téléphone</label>
                                            <input type="text" class="form-control" id="identifiant" name="identifiant" placeholder="Entrez votre identifiant" required>
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="#" class="text-muted">Mot de passe oublié ?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Mot de passe</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Entrez votre mot de passe" id="password-input" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-muted password-addon" type="button" id="password-addon">
                                                    <i class="ri-eye-fill align-middle"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Se souvenir de moi</label>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Se connecter</button>
                                        </div>

                                        
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="mb-0">Vous n’avez pas de compte ? <a href="/request" class="fw-semibold text-primary text-decoration-underline">Faire une demande</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="mb-0 text-muted">&copy;
                            <script>document.write(new Date().getFullYear())</script> JANDOUBA. Tous droits réservés.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
    <script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
</body>
</html>
