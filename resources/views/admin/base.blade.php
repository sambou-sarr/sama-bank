<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sama Bank - Gestion Bancaire</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
   <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
            body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #2e4f45;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            }

            .logo {
            font-size: 1.8rem;
            font-weight: bold;
            }

            nav .nav-link.active::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ffd700;
            }

            .hero {
            background-color: #2e4f45;
            color: white;
            padding: 3rem 2rem;
            }

            .hero h1 {
            font-size: 2.8rem;
            margin-bottom: 1rem;
            }

            .hero p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            }

            .hero .btn-primary {
            background-color: #ffd700;
            color: #1e3a34;
            border: none;
            margin-right: 1rem;
            }

            .hero .btn-secondary {
            border: 1px solid #ffd700;
            background: transparent;
            color: white;
            }

            footer {
            background-color: #1e3a34;
            color: #ccc;
            padding: 3rem 2rem 2rem;
            }

            footer h5 {
            color: #ffd700;
            text-transform: uppercase;
            margin-bottom: 1rem;
            }

            footer a {
            color: #ccc;
            text-decoration: none;
            }

            footer a:hover {
            color: #ffd700;
            }

            .social-links .btn {
            border-color: #ffd700;
            color: #ffd700;
            }

            .social-links .btn:hover {
            background-color: #ffd700;
            color: #1e3a34;
            }

            .footer-legal {
            border-top: 1px solid #555;
            margin-top: 2rem;
            padding-top: 1rem;
            font-size: 0.9rem;
            }

            .newsletter input {
            border: none;
            }

            .navbar .nav-link.active {
            color: #ffc107 !important;      /* jaune doré */
            font-weight: bold;
            border-bottom: 2px solid #ffc107;
            }

            .navbar .nav-link:hover {
            color: #ffdd57 !important;
            }
            /* Style du bouton Connexion au survol */
        .btn-outline-light:hover {
            color: #1e3a34 !important;
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
            font-weight: bold;
        }
        /* Personnaliser le fond du dropdown pour le thème sombre */
            .dropdown-menu {
            background-color: #1e3a34;
            color: #fff;
            }

            /* Couleur des liens dans le dropdown */
            .dropdown-menu .dropdown-item {
            color: #ffc107;
            }

            /* Hover / focus sur les items */
            .dropdown-menu .dropdown-item:hover,
            .dropdown-menu .dropdown-item:focus {
            background-color: #ffc107;
            color: #1e3a34;
            }

            /* Style bouton dans dropdown */
            .dropdown-menu button.dropdown-item {
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            }
            .compte-card:hover div {
                transform: translateY(-3px);
                transition: all 0.3s ease-in-out;
            }

    </style>
</head>
<body>

<!-- NAVBAR -->
 <nav class="navbar navbar-expand-lg navbar-dark px-4"  style="background-color: #1e3a34; font-size: 1.5rem;">
    <a class="navbar-brand logo" href="{{route('admin.dashboard')}}"><span class="fw-bold text-warning">Sama Bank</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Liens centrés -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('demande') ? 'active' : '' }}" href="{{ route('demande') }}">Comptes</a>
            </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.transactions') ? 'active' : '' }}" href="{{ route('admin.transactions') }} ">Transactions</a>
            </li>
        </ul>
    </div>

    <!-- Dropdown profil/déconnexion -->
    
  @auth
    <div class="dropdown ms-auto">
        <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <span>{{ Auth::user()->prenom }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <!-- Lien vers le profil -->
            <li>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    {{ __('Profile') }}
                </a>
            </li>

            <!-- Bouton de déconnexion -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        {{ __('Deconnection') }}
                    </button>
                </form>
            </li>
        </ul>
    </div>
  @endauth
  @guest
    <a href="/login" class="btn btn-outline-light d-flex align-items-center">
        Connexion
    </a>
  @endguest
    </div>
</nav>
    
    <div class="containeur">
        @yield('content')
    </div>
    <br><br><br><br>
    <footer class="mt-auto">
    <div class="container">
      <div class="row text-center text-md-start">

        <!-- À propos -->
        <div class="col-md-4 mb-4">
          <h5>À propos</h5>
          <p>Sunu Bank vous accompagne avec des services bancaires rapides, sécurisés et modernes.</p>
        </div>

                <div class="col-md-3 mb-3">
                    <h5>Contactez-nous</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <p><i class="fas fa-phone me-2"></i>+221 77 247 61 60 </p>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            sarrsambou03@gmail.com
                        </li>
                        <li class="mb-2">
                             <a href="https://wa.me/221773881690" class="text-white text-decoration-none">
                                <i class="fab fa-whatsapp me-2"></i>
                                 WhatsApp
                             </a>
                        </li>
                    </ul>
                </div>

        <!-- Newsletter -->
        <div class="col-md-4 mb-4">
          <h5>Newsletter</h5>
          <form class="d-flex">
            <input type="email" class="form-control me-2" placeholder="Votre email" />
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-paper-plane"></i>
            </button>
          </form>
          <div class="social-links mt-3">
            <a href="#" class="btn btn-outline-light rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="btn btn-outline-light rounded-circle me-2"><i class="fab fa-instagram"></i></a>
            <a href="#" class="btn btn-outline-light rounded-circle"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
      </div>

      <div class="footer-legal text-center mt-4">
        &copy; <span id="year"></span> Sama Bank — Tous droits réservés. Conçu par <a href="#">Sambou Sarr</a>
      </div>
    </div>
  </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
