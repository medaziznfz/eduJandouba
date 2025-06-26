<!doctype html>
<html lang="fr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Vérification du code | Jendouba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Modèle Premium d'Administration & Tableau de bord" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- CSS -->
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
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1440 120">
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

                                <div class="mb-4 text-center">
                                    <div class="avatar-lg mx-auto">
                                        <div class="avatar-title bg-light text-primary display-5 rounded-circle">
                                            <i class="ri-mail-line"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2 mt-4">
                                    <div class="text-muted text-center mb-4 mx-lg-3">
                                        <h4>Vérifiez votre code</h4>
                                        <p>Veuillez saisir le code à 4 chiffres envoyé à <span class="fw-semibold">{{ $email }}</span></p>
                                    </div>

                                    @if(session('success'))
                                        <div class="alert alert-success text-center">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger text-center">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    @error('code')
                                        <div class="alert alert-danger text-center">{{ $message }}</div>
                                    @enderror

                                    <form method="POST" action="{{ route('password.code.verify') }}" autocomplete="off" id="codeForm">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <input type="hidden" name="code" id="codeInput" value="">

                                        <div class="row">
                                            @for ($i = 1; $i <= 4; $i++)
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="digit{{ $i }}" class="visually-hidden">Chiffre {{ $i }}</label>
                                                        <input
                                                            type="text"
                                                            maxlength="1"
                                                            pattern="[0-9]"
                                                            inputmode="numeric"
                                                            name="digit{{ $i }}"
                                                            id="digit{{ $i }}"
                                                            class="form-control form-control-lg bg-light border-light text-center @error('digit'.$i) is-invalid @enderror"
                                                            required
                                                        >
                                                        @error('digit'.$i)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>

                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-success w-100">Confirmer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- 🔁 Lien de renvoi de code (sous la carte) -->
                        <div class="mt-4 text-center">
                            <form method="POST" action="{{ route('password.code.resend') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <p class="mb-0">
                                    Vous n'avez pas reçu de code ?
                                    <button type="submit" class="btn btn-link fw-semibold text-primary text-decoration-underline p-0 m-0 align-baseline">Renvoyer</button>
                                </p>
                            </form>
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
                            <script>document.write(new Date().getFullYear())</script> Jendouba. Tous droits réservés.
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
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
    <script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[name^="digit"]');

            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    input.value = input.value.replace(/[^0-9]/g, '');
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updateHiddenCode();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && input.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

            function updateHiddenCode() {
                let code = '';
                inputs.forEach(input => {
                    code += input.value;
                });
                document.getElementById('codeInput').value = code;
            }

            inputs[0].focus();

            document.getElementById('codeForm').addEventListener('submit', function(e) {
                let valid = true;
                inputs.forEach(input => {
                    if (input.value === '') valid = false;
                });
                if (!valid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les chiffres du code.');
                }
            });
        });
    </script>

</body>
</html>
