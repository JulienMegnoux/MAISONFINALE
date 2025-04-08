<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des objets connectés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        table {
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            vertical-align: middle !important;
            text-align: center;
        }
        .btn-toggle-activated {
            background-color: #5cb85c;
            color: white;
        }
        .btn-toggle-deactivated {
            background-color: #d9534f;
            color: white;
        }
        .btn-action {
            margin: 2px;
        }
        .badge-parametre {
            font-size: 0.9em;
        }
        a, a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">📡 Objets Connectés</h1>

    <div class="mb-4 text-center">
        <a href="{{ route('objets.create') }}" class="btn btn-primary">➕ Ajouter un nouvel objet</a>
        <a href="{{ route('rapports.index') }}" class="btn btn-info">📊 Voir le rapport</a>
        <a href="{{ route('statistiques.index') }}" class="btn btn-secondary">📈 Voir les statistiques</a>
        <a href="{{ route('objets.create') }}" class="btn btn-primary">➕ Ajouter un nouvel objet</a>
        <a href="{{ route('menu') }}" class="btn btn-success">🏠 Retour au menu principal</a>   
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>État</th>
                <th>Zone</th>
                <th>Paramètres</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($objets as $objet)
                <tr>
                    <td>{{ $objet->nom }}</td>
                    <td>{{ ucfirst($objet->type) }}</td>
                    <td>
                        <span class="badge {{ $objet->etat === 'inactif' ? 'bg-danger' : 'bg-success' }}">
                            {{ ucfirst($objet->etat) }}
                        </span>
                    </td>
                    <td>{{ $objet->zone?->nom ?? 'Non définie' }}</td>

                    <td>
                        @php $type = strtolower($objet->type); @endphp

                        @if ($type === 'portail')
                            <span class="badge bg-secondary badge-parametre">État: {{ $objet->etat_portail }}</span>
                        @elseif ($type === 'lampe')
                            <span class="badge bg-warning badge-parametre">Luminosité: {{ $objet->luminosite }}%</span>
                            @if ($objet->heure_debut && $objet->heure_fin)
                                <div class="badge bg-light text-dark">{{ $objet->heure_debut }} à {{ $objet->heure_fin }}</div>
                            @endif
                        @elseif ($type === 'volets')
                            <span class="badge bg-info badge-parametre">Position: {{ $objet->position }}%</span>
                        @elseif ($type === 'thermostat')
                            <span class="badge bg-danger badge-parametre">Temp. cible: {{ $objet->temperature_cible }}°C</span>
                        @elseif ($type === 'alarme')
                            <span class="badge bg-dark badge-parametre">Volume: {{ $objet->volume }}%</span>
                        @else
                            <span class="badge bg-secondary">Aucun paramètre</span>
                        @endif
                    </td>

                    <td>
                        <form method="POST" action="{{ route('objets.toggle', $objet->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $objet->etat === 'inactif' ? 'btn-toggle-deactivated' : 'btn-toggle-activated' }} btn-action">
                                @if($objet->etat === 'inactif')
                                    🔴 Désactivé
                                @else
                                    🟢 Activé
                                @endif
                            </button>
                        </form>

                        <a href="{{ route('objets.edit', $objet->id) }}" class="btn btn-sm btn-warning btn-action">✏️ Modifier</a>

                        @php
                            $demandeExistante = \App\Models\DemandeSuppression::where('objet_connecte_id', $objet->id)
                                                ->where('user_id', auth()->id())
                                                ->exists();
                        @endphp

                        @if (!$demandeExistante)
                            <form method="POST" action="{{ route('demande.suppression', $objet->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger btn-action">🗑️ Supprimer</button>
                            </form>
                        @else
                            <span class="badge bg-secondary btn-action">🕓 Demande envoyée</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>