<!doctype html>
<html lang="fr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Vérification du statut | Jendouba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Statut de la demande Jendouba" name="description" />
    <meta content="fedi" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- CSS principal -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="auth-page-wrapper pt-5">
        <!-- fond visuel -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- contenu -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="/" class="d-inline-block auth-logo">
                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="50">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Vérification du statut de demande Jendouba</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Vérifiez votre demande</h5>
                                    <p class="text-muted">Veuillez entrer votre CIN et votre adresse email</p>
                                </div>

                                <div class="p-2 mt-4">
                                    @if($errors->any())
                                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                                    @endif

                                    @isset($status)
                                        <div class="alert alert-info text-center fw-semibold">
                                            Statut actuel : {{ $status }}
                                        </div>
                                    @endisset

                                    <form method="POST" action="{{ route('request.status.check') }}" class="needs-validation" novalidate>
                                        @csrf

                                        <div class="mb-3">
                                            <label for="cin" class="form-label">CIN <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="cin" name="cin" placeholder="Entrez votre numéro CIN" required pattern="\d{8}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Adresse Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre adresse email" required>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Vérifier le statut</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ url('/request') }}" class="fw-semibold text-primary text-decoration-underline">Retour au formulaire</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- pied de page -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> Jendouba. Tous droits réservés.
                            </p>
                        </div>
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
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
    <script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>
</body>
</html>
