<!doctype html>
<html lang="fr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Créer un nouveau mot de passe | Jendouba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Modèle d'administration & tableau de bord premium" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- fond -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" 
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 
                    C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
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
                                    <img src="assets/images/logo-light.png" alt="Logo" height="50">
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Créer un nouveau mot de passe</h5>
                                    <p class="text-muted">Votre nouveau mot de passe doit contenir au moins 8 caractères.</p>
                                </div>

                                <div class="p-2">
                                    <form method="POST" action="#" id="resetPasswordForm" novalidate>
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Mot de passe</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input 
                                                    type="password" 
                                                    name="password" 
                                                    class="form-control pe-5 password-input" 
                                                    onpaste="return false" 
                                                    placeholder="Entrez le mot de passe" 
                                                    id="password-input" 
                                                    aria-describedby="passwordHelp"
                                                    minlength="8"
                                                    required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" 
                                                        type="button" id="toggle-password"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                            <div id="passwordHelp" class="form-text">Doit contenir au moins 8 caractères.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="confirm-password-input">Confirmer le mot de passe</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input 
                                                    type="password" 
                                                    name="password_confirmation" 
                                                    class="form-control pe-5 password-input" 
                                                    onpaste="return false" 
                                                    placeholder="Confirmer le mot de passe" 
                                                    id="confirm-password-input" 
                                                    minlength="8"
                                                    required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" 
                                                        type="button" id="toggle-confirm-password"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                            <!-- Alerte Bootstrap cachée au départ -->
                                            <div id="confirmPasswordAlert" class="alert alert-danger py-2 px-3" style="display:none; font-size: 0.9em;">
                                                <i class="mdi mdi-alert-circle-outline me-2"></i> Les mots de passe ne correspondent pas.
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Réinitialiser le mot de passe</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- fin card body -->
                        </div>
                        <!-- fin card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Vous vous souvenez de votre mot de passe ? 
                                <a href="{{ url('login') }}" class="fw-semibold text-primary text-decoration-underline"> Connectez-vous ici </a>
                            </p>
                        </div>

                    </div>
                </div>
                <!-- fin row -->
            </div>
            <!-- fin container -->
        </div>
        <!-- fin contenu -->

        <!-- footer -->
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
        <!-- fin footer -->
    </div>
    <!-- fin auth-page-wrapper -->

    <!-- SCRIPTS -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/plugins.js"></script>

    <!-- particles js -->
    <script src="assets/libs/particles.js/particles.js"></script>

    <!-- particles app js -->
    <script src="assets/js/pages/particles.app.js"></script>

    <!-- toggle password -->
    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const input = document.getElementById('password-input');
            input.type = input.type === 'password' ? 'text' : 'password';
        });
        document.getElementById('toggle-confirm-password').addEventListener('click', function () {
            const input = document.getElementById('confirm-password-input');
            input.type = input.type === 'password' ? 'text' : 'password';
        });

        // Validation des mots de passe identiques avant envoi
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            const pwd = document.getElementById('password-input').value;
            const confirmPwd = document.getElementById('confirm-password-input').value;
            const alertDiv = document.getElementById('confirmPasswordAlert');

            if (pwd !== confirmPwd) {
                e.preventDefault();
                alertDiv.style.display = 'block';
            } else {
                alertDiv.style.display = 'none';
            }
        });
    </script>

</body>

</html>
