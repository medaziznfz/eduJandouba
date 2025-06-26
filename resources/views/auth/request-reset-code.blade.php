<!doctype html>
<html lang="fr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <title>Réinitialisation du mot de passe | Jendouba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Modèle Premium d'Administration & Tableau de bord" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="auth-page-wrapper pt-5">

    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>
        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <a href="index.html" class="d-inline-block auth-logo">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="Logo" height="50">
                        </a>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4 card-bg-fill">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Mot de passe oublié ?</h5>
                                <p class="text-muted">Réinitialisez votre mot de passe</p>

                                <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl"></lord-icon>
                            </div>

                            <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                                Entrez votre CIN, email et téléphone pour recevoir les instructions !
                            </div>

                            {{-- Affichage d’une erreur générale si besoin --}}
                            @if(session('error'))
                                <div class="alert alert-danger text-center">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="p-2">
                                <form method="POST" action="{{ route('password.code.send') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="cin" class="form-label">CIN</label>
                                        <input type="text" class="form-control @error('cin') is-invalid @enderror" id="cin" name="cin" placeholder="Entrez votre CIN" value="{{ old('cin') }}" required>
                                        @error('cin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Entrez votre email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" placeholder="Entrez votre numéro" value="{{ old('telephone') }}" required>
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-center mt-4">
                                        <button class="btn btn-success w-100" type="submit">Envoyer le code</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="mb-0">Finalement, j'ai retrouvé mon mot de passe... <a href="{{ url('login') }}" class="fw-semibold text-primary text-decoration-underline"> Me connecter </a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="mb-0 text-muted">&copy;
                        <script>document.write(new Date().getFullYear())</script> Jendouba. Tous droits réservés.
                    </p>
                </div>
            </div>
        </div>
    </footer>

</div>

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
