<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Tableau de bord')</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS directement intégré -->
    <style>
        /* Styles personnalisés directement dans la vue */
        body {
            background-color: #e0e0e0 !important;
            color: #333 !important;
            font-family: Arial, sans-serif !important;
            padding-top: 20px !important;
        }

        .navbar {
            background-color: #007bff !important;
        }

        .navbar-brand {
            font-weight: bold !important;
            color: white !important;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.2) !important;
        }

        .container {
            max-width: 1200px !important;
            margin: auto !important;
            padding: 20px !important;
        }

        h1, h2, h3 {
            color: #333 !important;
        }

        button, .btn {
            background-color: #007bff !important;
            color: white !important;
            border-radius: 4px !important;
            padding: 10px 15px !important;
            border: none !important;
        }

        button:hover, .btn:hover {
            background-color: #0056b3 !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        table th, table td {
            padding: 10px !important;
            text-align: left !important;
            border-bottom: 1px solid #ddd !important;
        }

        table th {
            background-color: #f8f9fa !important;
        }

        table tr:hover {
            background-color: #f1f1f1 !important;
        }

        .card {
            background-color: #fff !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
            margin-bottom: 20px !important;
        }

        .card-header {
            background-color: #28a745 !important;
            color: white !important;
            padding: 10px !important;
            font-weight: bold !important;
        }

        .card-body {
            padding: 15px !important;
        }
    </style>

</head>

<body class="page-body">
    <nav class="navbar navbar-expand-lg navbar-dark">
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
                            <a class="nav-link" href="{{ route('menu') }}">🏠 Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">👥 Membres</a>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('connexion') }}">Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inscription') }}">S'inscrire</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
