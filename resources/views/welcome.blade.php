<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-layout="vertical" data-topbar="light" data-sidebar="dark"
      data-sidebar-size="lg" data-sidebar-image="none"
      data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>SmartEdu – Accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="SmartEdu plateforme de formation" name="description" />
    <meta content="Fedi" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Velzon CSS -->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" />

    <!-- layout config -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>

    <style>
      /* Hero buttons skew + spacing */
      .hero-buttons-wrapper {
        margin-bottom: 10rem;
        display: inline-block;
        transform: skew(-20deg);
      
      }
      .hero-buttons-wrapper {
        display: inline-block;
        transform: skew(0deg);
      }
      /* small bottom-gap on mobile so stacked buttons don’t touch */
      @media (max-width: 576px) {
        .hero-buttons-wrapper a,
        .hero-buttons-wrapper button {
          margin-bottom: 1rem;
        }
      }
    </style>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbarNav" data-bs-offset="80" tabindex="0">

<div class="layout-wrapper landing">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('assets/images/logo-dark.png') }}" height="30" class="card-logo-dark" alt="logo dark">
        <img src="{{ asset('assets/images/logo-light.png') }}" height="30" class="card-logo-light" alt="logo light">
      </a>
      <button class="navbar-toggler" type="button"
              data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false"
              aria-label="Toggle navigation">
        <i class="mdi mdi-menu"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link" href="#hero">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="#apropos">À propos</a></li>
          <li class="nav-item"><a class="nav-link" href="#pourquoi">Pourquoi</a></li>
          <li class="nav-item"><a class="nav-link" href="#etablissements">Établissements</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        </ul>
        <div class="d-flex">
          @guest
            <button
              type="button"
              onclick="window.location='{{ route('login') }}';"
              class="btn btn-ghost-secondary waves-effect material-shadow-none">
              Se connecter
            </button>
          @else
            @php
              $role = auth()->user()->role;
              $dash = match($role) {
                'user'  => 'user.dashboard',
                'etab'  => 'etab.dashboard',
                'univ'  => 'univ.dashboard',
                'super' => 'super.dashboard',
                default => 'login'
              };
            @endphp
            <button
              type="button"
              onclick="window.location='{{ route($dash) }}';"
              class="btn btn-ghost-info waves-effect waves-light material-shadow-none">
              Tableau de bord
            </button>
          @endguest
        </div>
      </div>
    </div>
  </nav>
  <div class="vertical-overlay" data-bs-toggle="collapse" data-bs-target="#navbarNav.show"></div>

  <!-- HERO -->
  <section id="hero" class="section pb-0 hero-section"
           style="background: url('{{ asset('assets/images/auth-one-bg.jpg') }}') center/cover no-repeat;">
    <div class="bg-overlay bg-overlay-pattern"></div>
    <div class="container text-center text-white">
      <div class="row justify-content-center">
        <div class="col-lg-8 pt-5">
          <h1 class="display-6 fw-semibold mb-3 lh-base">
            Gérer vos formations simplement avec
            <span class="text-success">SmartEdu</span>
          </h1>
          <p class="lead mb-4">
            Plate-forme tout-en-un pour publier, valider et suivre vos formations.
          </p>
          <div class="hero-buttons-wrapper">
            <button
              type="button"
              onclick="window.location='{{ url('/request') }}';"
              class="btn btn-primary btn-label waves-effect waves-light rounded-pill me-2">
              <i class="ri-error-warning-line label-icon align-middle rounded-pill fs-16 me-2"></i>
              Envoyer une demande
            </button>

            <button 
              type="button" 
              onclick="window.location='{{ route('request.status.form') }}';" 
              class="btn btn-danger btn-label waves-effect waves-light rounded-pill">
              <i class="ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2"></i>
              Consulter statut
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Hero Shape SVG -->
    <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120">
        <path fill="currentColor" d="M0,118 C288,98.6 1152,40.4 1440,21 L1440,140 L0,140 Z"></path>
      </svg>
    </div>
  </section>

  <!-- À PROPOS -->
  <section id="apropos" class="section pt-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2>À propos de SmartEdu</h2>
        <p class="text-muted">
          SmartEdu met en relation candidats et établissements,
          avec un suivi en temps réel de chaque demande d’inscription.
        </p>
      </div>
    </div>
  </section>

  <!-- POURQUOI -->
  <section id="pourquoi" class="section bg-light">
    <div class="container">
      <div class="row align-items-center gy-4">
        <div class="col-lg-6 order-lg-2 text-center">
          <img src="{{ asset('assets/images/landing/features/img-2.png') }}"
               alt="Dashboard design" class="img-fluid">
        </div>
        <div class="col-lg-6 order-lg-1 ps-lg-5">
          <h5 class="fs-12 text-uppercase text-success">Pourquoi SmartEdu ?</h5>
          <h4 class="mb-3">Vos avantages clés</h4>
          <p class="mb-4 ff-secondary">
            Découvrez comment SmartEdu optimise la gestion de vos formations :
          </p>
          <ul class="list-unstyled vstack gap-3 ff-secondary">
            @foreach([
              'Gestion centralisée des demandes',
              'Suivi en temps réel',
              'Validation automatisée',
              'Rapports et statistiques',
              'Sécurité des données'
            ] as $benefit)
              <li class="d-flex">
                <div class="flex-shrink-0 text-success me-2">
                  <i class="ri-check-fill fs-15"></i>
                </div>
                <div class="flex-grow-1">{{ $benefit }}</div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ÉTABLISSEMENTS -->
  <section id="etablissements" class="section pt-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2>Nos établissements partenaires</h2>
      </div>
      <div class="row">
        @foreach($etablissements as $etab)
          <div class="col-xl-4 mb-4">
            <div class="card">
              <div class="card-body p-4 text-center">
                <div class="mx-auto avatar-md mb-3">
                  <i class="ri-building-4-line fs-40 text-primary"></i>
                </div>
                <h5 class="card-title mb-1">{{ $etab->nom }}</h5>
                <p class="text-muted mb-0">{{ $etab->ville ?? '—' }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- CONTACT -->
  <section id="contact" class="section bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-5">
          <h3 class="mb-3 fw-semibold">Get In Touch</h3>
          <p class="text-muted mb-4 ff-secondary">
            Des questions ? Écrivez-nous un message, nous reviendrons vers vous !
          </p>
        </div>
      </div>
      <div class="row gy-4">
        <div class="col-lg-4">
          <div>
            <div class="mt-4">
              <h5 class="fs-13 text-muted text-uppercase">Adresse 1 :</h5>
              <div class="ff-secondary fw-semibold">
                4461 Cedar Street Moro, AR 72368
              </div>
            </div>
            <div class="mt-4">
              <h5 class="fs-13 text-muted text-uppercase">Adresse 2 :</h5>
              <div class="ff-secondary fw-semibold">
                2467 Swick Hill Street, New Orleans, LA
              </div>
            </div>
            <div class="mt-4">
              <h5 class="fs-13 text-muted text-uppercase">Horaires :</h5>
              <div class="ff-secondary fw-semibold">9h00 – 18h00</div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <form id="contactForm">
            <div class="row">
              <div class="col-md-6 mb-4">
                <label for="name" class="form-label fs-13">Nom</label>
                <input type="text" id="name" class="form-control bg-white border-light" placeholder="Votre nom*" required>
              </div>
              <div class="col-md-6 mb-4">
                <label for="email" class="form-label fs-13">Email</label>
                <input type="email" id="email" class="form-control bg-white border-light" placeholder="Votre email*" required>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mb-4">
                <label for="subject" class="form-label fs-13">Sujet</label>
                <input type="text" id="subject" class="form-control bg-white border-light" placeholder="Votre sujet.." required>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mb-4">
                <label for="comments" class="form-label fs-13">Message</label>
                <textarea id="comments" rows="4" class="form-control bg-white border-light" placeholder="Votre message..." required></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-12 text-end">
                <button type="submit" class="submitBnt btn btn-primary">Envoyer</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Back to top -->
  <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
  </button>

</div>

<!-- Velzon JS + Swiper + SweetAlert2 -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/landing.init.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('contactForm').addEventListener('submit', function(e){
    e.preventDefault();
    Swal.fire({
      icon: 'info',
      title: 'À venir',
      text: 'Cette fonctionnalité sera bientôt disponible !',
    });
  });

  function topFunction() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>

</body>
</html>
