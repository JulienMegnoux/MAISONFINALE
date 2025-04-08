<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Menu Principal - Maison Connectée</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 1000px;
      margin: auto;
    }
    .piece {
      background: #fff;
      margin-bottom: 20px;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .appareils {
      margin-left: 20px;
    }
    .appareil {
      padding: 5px 0;
    }
    .gestion-btn {
      text-align: center;
      margin-bottom: 20px;
    }
    .gestion-btn a button {
      padding: 10px 20px;
      background: #3490dc;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  {{-- NAVBAR --}}
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Maison Connectée</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          @auth
            <li class="nav-item">
              <a class="nav-link" href="{{ route('profil.edit') }}">👤 Modifier mon profil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('objets.index') }}">🏠 Objets</a>
            </li>
            @if(Auth::user()->email === 'julien.megnoux@me.com')
              <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">🔒 Espace Admin</a>
              </li>
            @endif
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link text-light">🚪 Déconnexion</button>
              </form>
            </li>
          @endauth
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('connexion') }}">Se connecter</a>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <h1>Bienvenue dans votre maison connectée</h1>

    <div class="gestion-btn">
      <a href="{{ route('objets.index') }}">
        <button>Accéder aux Objets</button>
      </a>
    </div>

    @foreach($pieces as $piece)
      <div class="piece">
        <h2>{{ $piece->nom }}</h2>
        <div class="appareils">
          @forelse($piece->appareils as $appareil)
            <div class="appareil">🔌 {{ $appareil->nom }}</div>
          @empty
            <p>Aucun appareil dans cette pièce.</p>
          @endforelse
        </div>
      </div>
    @endforeach
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
