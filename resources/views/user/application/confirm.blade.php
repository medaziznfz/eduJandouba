<!DOCTYPE html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="none" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Détails de l'Application | {{ $formation->titre ?? 'Invalide' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="FEDI" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="bg-light" style="overflow: hidden;">

    <div class="main-content" style="min-height: 100vh; display: flex; justify-content: center; align-items: center;">

        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="bg-warning-subtle position-relative">
                            <div class="card-body p-5">
                                <div class="text-center">
                                    <h3>Détails de l'Application à la Formation</h3>
                                    <p class="mb-0 text-muted">Cliquez sur l'un des boutons pour accepter ou refuser l'inscription à la formation.</p>
                                </div>
                            </div>
                            <div class="shape">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="1440" height="60" preserveAspectRatio="none" viewBox="0 0 1440 60">
                                    <g mask="url(&quot;#SvgjsMask1001&quot;)" fill="none">
                                        <path d="M 0,4 C 144,13 432,48 720,49 C 1008,50 1296,17 1440,9L1440 60L0 60z" style="fill: var(--vz-secondary-bg);"></path>
                                    </g>
                                    <defs>
                                        <mask id="SvgjsMask1001">
                                            <rect width="1440" height="60" fill="#ffffff"></rect>
                                        </mask>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <!-- Show Error Message if Hash is Invalid -->
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @else
                                <!-- Only show formation details if hash is valid -->
                                <div>
                                    <h5>Formation: {{ $formation->titre ?? 'Invalide' }}</h5>
                                    <p class="text-muted">Description: {{ $formation->description }}</p>
                                    <p class="text-muted">Date limite: {{ \Carbon\Carbon::parse($formation->deadline)->format('d M, Y') }}</p>
                                    <p class="text-muted">Durée: {{ $formation->duree }}</p>
                                    <p class="text-muted">Lieu: {{ $formation->lieu }}</p>
                                    <p class="text-muted">Capacité: {{ $formation->capacite }}</p>
                                    <p class="text-muted">Date de début: {{ $formation->start_at ? \Carbon\Carbon::parse($formation->start_at)->format('d M, Y') : 'Non défini' }}</p>
                                </div>

                                <!-- Display Status-based Messages and Buttons -->
                                @if($application->status === 4)
                                    <div class="alert alert-success">
                                        Vous avez déjà confirmé votre inscription à cette formation.
                                    </div>
                                @elseif($application->status === 2)
                                    <div class="alert alert-danger">
                                        Votre inscription a été refusée.
                                    </div>
                                @else
                                    <div class="text-end hstack gap-2 justify-content-end mt-4">
                                        <!-- Confirm Button -->
                                        <form id="accept-form" action="{{ route('user.application.confirmAction', ['application' => $application->id, 'hash' => $application->hash]) }}" method="POST">
                                            @csrf
                                            <button type="button" class="btn btn-success" id="accept-btn">Accepter</button>
                                        </form>

                                        <!-- Decline Button -->
                                        <form id="decline-form" action="{{ route('user.application.declineAction', ['application' => $application->id, 'hash' => $application->hash]) }}" method="POST">
                                            @csrf
                                            <button type="button" class="btn btn-outline-danger" id="decline-btn"><i class="ri-close-line align-bottom me-1"></i> Refuser</button>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <!-- Footer -->
    <footer class="footer" style="position: absolute; bottom: 0; width: 100%;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © Jendouba.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by Fedi Bejaoui
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- SweetAlert for confirmation/decline -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Handle confirmation click
            document.getElementById('accept-btn')?.addEventListener('click', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: 'Confirmer votre inscription',
                    text: "Voulez-vous vraiment accepter cette inscription ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, accepter',
                    cancelButtonText: 'Annuler'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById('accept-form').submit();
                    }
                });
            });

            // Handle decline click
            document.getElementById('decline-btn')?.addEventListener('click', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: 'Confirmer le refus',
                    text: "Voulez-vous vraiment refuser cette inscription ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, refuser',
                    cancelButtonText: 'Annuler'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById('decline-form').submit();
                    }
                });
            });
        });
    </script>

</body>
</html>
