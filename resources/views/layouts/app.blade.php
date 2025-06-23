<!doctype html>
<html lang="fr" data-layout="vertical" data-topbar="light" data-sidebar="dark"
      data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable"
      data-theme="default" data-theme-colors="default">
<head>
  <meta charset="utf-8" />
  <title>Jendouba SmartEdu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Modèle d’administration et de tableau de bord multifonction premium" />
  <meta name="author" content="fedi" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
  <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
  @stack('styles')
</head>

<body>

  <div id="layout-wrapper">

    <!-- ===================== EN-TÊTE ===================== -->
    <header id="page-topbar">
      <div class="layout-width">
        <div class="navbar-header">
          <div class="d-flex">
            <div class="navbar-brand-box horizontal-logo">
              <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="logo logo-dark">
                <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo"></span>
                <span class="logo-lg"><img src="{{ asset('assets/images/logo-dark.png') }}" height="40" alt="logo"></span>
              </a>
              <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="logo logo-light">
                <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo"></span>
                <span class="logo-lg"><img src="{{ asset('assets/images/logo-light.png') }}" height="40" alt="logo"></span>
              </a>
            </div>
            <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none" id="topnav-hamburger-icon">
              <span class="hamburger-icon"><span></span><span></span><span></span></span>
            </button>
          </div>
          <div class="d-flex align-items-center">

            <!-- recherche mobile -->
            <div class="dropdown d-md-none topbar-head-dropdown header-item">
              <button class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown">
                <i class="bx bx-search fs-22"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                <form class="p-3">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher ..." aria-label="Recherche">
                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                  </div>
                </form>
              </div>
            </div>

            <!-- plein écran -->
            <div class="ms-1 header-item d-none d-sm-flex">
              <button class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                <i class='bx bx-fullscreen fs-22'></i>
              </button>
            </div>

            <!-- mode clair/sombre -->
            <div class="ms-1 header-item d-none d-sm-flex">
              <button class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle light-dark-mode">
                <i class='bx bx-moon fs-22'></i>
              </button>
            </div>

            <!-- notifications -->
            <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
              <button class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown"
                      data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                <i class='bx bx-bell fs-22'></i>
                <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                  {{ auth()->user()->unreadNotifications->count() }}
                  <span class="visually-hidden">notifications non lues</span>
                </span>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                <!-- en-tête du dropdown -->
                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                  <div class="p-3">
                    <div class="row align-items-center">
                      <div class="col"><h6 class="m-0 fs-16 fw-semibold text-white">Notifications</h6></div>
                      <div class="col-auto dropdown-tabs">
                        <span class="badge bg-light text-body fs-13">{{ auth()->user()->unreadNotifications->count() }} nouvelles</span>
                      </div>
                    </div>
                  </div>
                  <div class="px-2 pt-2">
                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                      <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#unread-noti-tab" role="tab" aria-selected="true">
                          Non lues ({{ auth()->user()->unreadNotifications->count() }})
                        </a>
                      </li>
                      <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="false">
                          Tout
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>

                <!-- contenu des onglets -->
                <div class="tab-content position-relative" id="notificationItemsTabContent">

                  <!-- onglet Non lues -->
                  <div class="tab-pane fade show active py-2 ps-2" id="unread-noti-tab" role="tabpanel">
                    <div data-simplebar style="max-height: 300px;" class="pe-2" id="notifications-list">
                      @if(auth()->user()->unreadNotifications->isEmpty())
                        <div class="text-center py-5">
                          <img src="{{ asset('assets/images/svg/bell.svg') }}" alt="Aucune notification" style="width:60px;" class="mb-3">
                          <p class="text-muted">Il n'y a pas de notification</p>
                        </div>
                      @else
                        @foreach(auth()->user()->unreadNotifications as $notification)
                          <div id="notification-{{ $notification->id }}" class="text-reset notification-item d-block dropdown-item position-relative">
                            <div class="d-flex">
                              <div class="avatar-xs me-3 flex-shrink-0">
                                <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                  <i class="bx bx-badge-check"></i>
                                </span>
                              </div>
                              <div class="flex-grow-1">
                                <a href="{{ $notification->redirect_link }}" class="stretched-link"
                                   onclick="event.preventDefault(); markAndGo({{ $notification->id }}, '{{ $notification->redirect_link }}')">
                                  <h6 class="mt-0 mb-2 lh-base">{{ $notification->title }}</h6>
                                  <p class="fs-12 mb-1 text-muted">{{ $notification->subtitle }}</p>
                                </a>
                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                  <i class="mdi mdi-clock-outline"></i> {{ $notification->created_at->diffForHumans() }}
                                </p>
                              </div>
                            </div>
                          </div>
                        @endforeach
                        <div class="my-3 text-center view-all">
                          <button id="mark-all-read-btn" type="button" class="btn btn-soft-success waves-effect waves-light w-100">
                            Tout marquer comme lus <i class="ri-arrow-right-line align-middle"></i>
                          </button>
                        </div>
                      @endif
                    </div>
                  </div>

                  <!-- onglet Tout -->
                  <div class="tab-pane fade py-2 ps-2" id="all-noti-tab" role="tabpanel">
                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                      @if(auth()->user()->notifications->isEmpty())
                        <div class="text-center py-5">
                          <img src="{{ asset('assets/images/svg/bell.svg') }}" alt="Aucune notification" style="width:60px;" class="mb-3">
                          <p class="text-muted">Il n'y a pas de notification</p>
                        </div>
                      @else
                        @foreach(auth()->user()->notifications as $notification)
                          <div id="notification-{{ $notification->id }}" class="text-reset notification-item d-block dropdown-item position-relative">
                            <div class="d-flex align-items-center">
                              <div class="avatar-xs me-3 flex-shrink-0">
                                <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                  <i class="bx bx-badge-check"></i>
                                </span>
                              </div>
                              <div class="flex-grow-1">
                                <a href="{{ $notification->redirect_link }}" class="stretched-link"
                                   onclick="event.preventDefault(); markAndGo({{ $notification->id }}, '{{ $notification->redirect_link }}')">
                                  <h6 class="mt-0 mb-2 lh-base">{{ $notification->title }}</h6>
                                  <p class="fs-12 mb-1 text-muted">{{ $notification->subtitle }}</p>
                                </a>
                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                  <i class="mdi mdi-clock-outline"></i> {{ $notification->created_at->diffForHumans() }}
                                </p>
                              </div>
                              @if(! $notification->read)
                                <div class="px-2">
                                  <i class="bx bx-star text-warning fs-18"></i>
                                </div>
                              @endif
                            </div>
                          </div>
                        @endforeach
                        <div class="my-3 text-center view-all">
                          <button type="button" class="btn btn-soft-success waves-effect waves-light w-100">
                            Voir toutes les notifications <i class="ri-arrow-right-line align-middle"></i>
                          </button>
                        </div>
                      @endif
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <!-- dropdown utilisateur -->
            <div class="dropdown ms-sm-3 header-item topbar-user">
              <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
                      data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="d-flex align-items-center">
                  <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="Avatar">
                  <span class="text-start ms-xl-2">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</span>
                    <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ ucfirst(auth()->user()->role) }}</span>
                  </span>
                </span>
              </button>
              <div class="dropdown-menu dropdown-menu-end">
                <h6 class="dropdown-header">Bienvenue !</h6>
                <a class="dropdown-item" href="{{ route('profile.index') }}">
                  <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> Profil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">
                  <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Se déconnecter
                </a>
              </div>
            </div>

          </div>
        </div>
      </header>
    <!-- ================= FIN EN-TÊTE ================= -->

    <!-- ================= MENU LATÉRAL ================= -->
    <div class="app-menu navbar-menu">
      <div class="navbar-brand-box">
        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="logo logo-dark">
          <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo"></span>
          <span class="logo-lg"><img src="{{ asset('assets/images/logo-dark.png') }}" height="40" alt="logo"></span>
        </a>
        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="logo logo-light">
          <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo"></span>
          <span class="logo-lg"><img src="{{ asset('assets/images/logo-light.png') }}" height="40" alt="logo"></span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
          <i class="ri-record-circle-line"></i>
        </button>
      </div>

      <div class="dropdown sidebar-user m-1 rounded">
        <button class="btn material-shadow-none" id="sidebar-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="d-flex align-items-center gap-2">
            <img class="rounded header-profile-user" src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="Avatar">
            <span class="text-start">
              <span class="d-block fw-medium sidebar-user-name-text">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</span>
              <span class="d-block fs-14 sidebar-user-name-sub-text">
                <i class="ri ri-circle-fill fs-10 text-success align-baseline"></i> En ligne
              </span>
            </span>
          </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <h6 class="dropdown-header">Bienvenue {{ auth()->user()->prenom }} !</h6>
          <a class="dropdown-item" href="{{ route('profile.index') }}">
            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}">
            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Se déconnecter
          </a>
        </div>
      </div>

      <div id="scrollbar">
        <div class="container-fluid">
          <div id="two-column-menu"></div>
          <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span>Menu</span></li>

            <li class="nav-item">
              <a class="nav-link menu-link" href="{{ route(auth()->user()->role . '.dashboard') }}">
                <i class="ri-dashboard-2-line"></i> Tableau de bord
              </a>
            </li>

            @if(auth()->user()->role === 'user')
              <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('user.formations.*') ? 'active' : '' }}" href="{{ route('user.formations.index') }}">
                  <i class="ri-folder-line"></i> Liste des formations
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('user.myFormations') ? 'active' : '' }}" href="{{ route('user.myFormations') }}">
                  <i class="ri-user-line"></i> Mes formations
                </a>
              </li>
            @elseif(auth()->user()->role === 'etab')
              <li class="nav-item">
                <a class="nav-link menu-link" href="{{ route('etab.requests') }}">
                  <i class="ri-file-search-line"></i> Valider les demandes d’inscription
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link menu-link" href="{{ route('etab.applications.index') }}">
                  <i class="ri-file-search-line"></i> Valider les demandes de participation
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sidebarEtabUsers" role="button" aria-expanded="false" aria-controls="sidebarEtabUsers">
                  <i class="ri-user-line"></i> Gestion des utilisateurs
                </a>
                <div class="collapse menu-dropdown" id="sidebarEtabUsers">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('etab.users.index') }}">Liste des utilisateurs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('etab.users.create') }}">Ajouter un utilisateur</a>
                    </li>
                  </ul>
                </div>
              </li>
            @elseif(auth()->user()->role === 'univ')
              <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sidebarFormations" role="button" aria-expanded="false" aria-controls="sidebarFormations">
                  <i class="ri-folder-line"></i> Formations
                </a>
                <div class="collapse menu-dropdown" id="sidebarFormations">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{ route('univ.formations.index') }}">Liste</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('univ.formations.create') }}">Créer formation</a></li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('univ.applications.*') ? 'active' : '' }}" href="{{ route('univ.applications.index') }}">
                  <i class="ri-building-line"></i> Valider les demandes de participation
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sidebarUsers" role="button" aria-expanded="false" aria-controls="sidebarUsers">
                  <i class="ri-user-line"></i> Gestion des utilisateurs
                </a>
                <div class="collapse menu-dropdown" id="sidebarUsers">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{ route('univ.users.index') }}">Liste des utilisateurs</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('univ.users.create') }}">Ajouter un utilisateur</a></li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link {{ request()->routeIs('univ.settings.*') ? 'active' : '' }}"
                  href="{{ route('univ.settings.index') }}"
                >
                  <i class="ri-settings-3-line"></i> Gestion des Grades & Établissements
                </a>
              </li>
           @elseif(auth()->user()->role === 'forma')
              <li class="nav-item">
                  <a href="{{ route('forma.formations.index') }}" class="nav-link">
                      <i class="ri-book-open-line"></i> Mes Formations
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('qrscanner.scan') }}" class="nav-link">
                      <i class="ri-check-line"></i> Vérifier une attestation
                  </a>
              </li>
          @endif

          </ul>
        </div>
      </div>
      <div class="sidebar-background"></div>
    </div>
    <!-- ================= FIN MENU LATÉRAL ================= -->

    <div class="vertical-overlay"></div>

    <!-- ================= CONTENU PRINCIPAL ================= -->
    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>

      <footer class="footer">
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
    </div>
    <!-- ================= FIN CONTENU PRINCIPAL ================= -->

  </div>

  <!--start back-to-top-->
  <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
      <i class="ri-arrow-up-line"></i>
  </button>
  <!--end back-to-top-->

  <!--preloader-->
  <div id="preloader">
      <div id="status">
          <div class="spinner-border text-primary avatar-sm" role="status">
              <span class="visually-hidden">Loading...</span>
          </div>
      </div>
  </div>


  <!-- boutons, préchargeur, customizer… -->
  <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top"><i class="ri-arrow-up-line"></i></button>
  <div id="preloader"><div id="status"><div class="spinner-border text-primary avatar-sm" role="status"><span class="visually-hidden">Loading...</span></div></div></div>

  <!-- scripts -->
  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
  <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
  <script src="{{ asset('assets/js/plugins.js') }}"></script>
  <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
  @stack('scripts')

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      window.markAndGo = function(id, url) {
        fetch(`/notifications/${id}/mark-as-read`, {
          method: 'POST',
          headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
        }).then(() => window.location = url);
      };

      const btn = document.getElementById('mark-all-read-btn');
      if (btn) {
        btn.addEventListener('click', () => {
          fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
          })
          .then(() => location.reload());
        });
      }
    });
  </script>

</body>
</html>
