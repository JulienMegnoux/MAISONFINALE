<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapports des objets connectés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
            margin-bottom: 20px;
        }
        /* Back button styling */
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            background: #666;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .back-btn:hover {
            background: #555;
        }
        /* Tabs styling */
        .tabs {
            margin-bottom: 20px;
            text-align: center;
        }
        .tabs a {
            margin-right: 15px;
            text-decoration: none;
            padding: 8px 16px;
            background: #eee;
            border-radius: 5px;
            color: #333;
            transition: background 0.3s, color 0.3s;
        }
        .tabs a.active {
            background: #4285f4;
            color: white;
        }
        /* Table styling enhancements using Bootstrap classes */\n        table {\n            width: 100%;\n            border-collapse: collapse;\n            margin-top: 20px;\n        }\n        th, td {\n            border: 1px solid #ccc;\n            padding: 12px;\n            text-align: center;\n            vertical-align: middle;\n        }\n        th {\n            background-color: #f2f2f2;\n        }\n        /* Responsive adjustments */\n        @media (max-width: 768px) {\n            th, td { padding: 8px; }\n            .tabs a { padding: 6px 12px; font-size: 0.9rem; }\n        }\n    </style>
</head>
<body>

    <a href="{{ route('objets.index') }}" class="back-btn">&larr; Retour au menu</a>

    <h1 class="text-center">Rapports des objets connectés</h1>

    <div class="tabs">
        <a href="{{ route('rapports.index', ['vue' => 'quotidien']) }}" class="{{ request()->routeIs('rapports.index') && request('vue', 'quotidien') === 'quotidien' ? 'active' : '' }}">Consommation quotidienne</a>
        <a href="{{ route('rapports.index', ['vue' => 'hebdomadaire']) }}" class="{{ request()->routeIs('rapports.index') && request('vue') === 'hebdomadaire' ? 'active' : '' }}">Consommation hebdomadaire</a>
        <a href="{{ route('rapports.anomalies') }}" class="{{ request()->routeIs('rapports.anomalies') ? 'active' : '' }}">Anomalies</a>
    </div>

    @if(isset($consommations))
        <h2>Consommation {{ $vue === 'hebdomadaire' ? 'hebdomadaire' : 'quotidienne' }}</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>État</th>
                        <th>Consommation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consommations as $objet)
                        <tr>
                            <td>{{ $objet['nom'] ?? 'N/A' }}</td>
                            <td>{{ $objet['type'] ?? 'N/A' }}</td>
                            <td>{{ $objet['etat'] ?? 'N/A' }}</td>
                            <td>{{ $vue === 'hebdomadaire' ? ($objet['conso_semaine'] ?? 0) : ($objet['conso_jour'] ?? 0) }} W</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(isset($anomalies))
        <h2>Anomalies détectées</h2>
        @if (count($anomalies) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Problème détecté</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anomalies as $a)
                            <tr>
                                <td>{{ $a['nom'] ?? 'N/A' }}</td>
                                <td>{{ $a['type'] ?? 'N/A' }}</td>
                                <td>
                                    @if (is_array($a['problemes']))
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($a['problemes'] as $probleme)
                                                <li>{{ $probleme }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $a['problemes'] ?? 'Anomalie non spécifiée' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>Aucune anomalie détectée. Tous les objets fonctionnent normalement ✅</p>
        @endif
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
