<!DOCTYPE html>
<html>
<head>
    <title>Statistiques</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        select, button { padding: 6px; margin-bottom: 10px; }
        .chart-container { display: flex; gap: 30px; overflow-x: auto; }
        .chart-box { width: 400px; flex: 0 0 auto; }
    </style>
</head>
<body>

    <h1>Statistiques</h1>

    <form method="GET" action="{{ route('statistiques.index') }}">
        <label>Vue :</label>
        <select name="vue" onchange="this.form.submit()">
            <option value="globales" {{ $vue === 'globales' ? 'selected' : '' }}>Globales</option>
            <option value="utilisation" {{ $vue === 'utilisation' ? 'selected' : '' }}>Utilisation</option>
            <option value="historique" {{ $vue === 'historique' ? 'selected' : '' }}>Historique</option>

        </select>
    </form>

    @if ($vue === 'globales')
        <div class="chart-container">
            <div class="chart-box">
                <canvas id="etatChart"></canvas>
            </div>
            <div class="chart-box">
                <canvas id="zoneChart"></canvas>
            </div>
            <div class="chart-box">
                <canvas id="moyennesChart"></canvas>
            </div>
        </div>
    @elseif ($vue === 'utilisation')
        <div class="chart-container">
            <div class="chart-box">
                <canvas id="activiteChart"></canvas>
            </div>
            <div class="chart-box">
                <canvas id="utilisationChart"></canvas>
            </div>
        </div>

        <h3>Objets les plus modifiés :</h3>
        <ul>
            @foreach ($stats['objetsModifies'] ?? [] as $objet)
                <li>{{ $objet }}</li>
            @endforeach
        </ul>
    @elseif ($vue === 'historique')
        <h2>Historique d’utilisation (7 derniers jours)</h2>
        <div style="width: 100%; overflow-x: auto;">
            <canvas id="historiqueChart" height="200"></canvas>
        </div>

        <script>
            const historiqueData = {
                labels: {!! json_encode(array_column($stats['historique'], 'jour')) !!},
                datasets: [{
                    label: 'Objets utilisés',
                    data: {!! json_encode(array_column($stats['historique'], 'utilisation')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            };

            new Chart(document.getElementById('historiqueChart'), {
                type: 'bar',
                data: historiqueData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nombre d’objets utilisés'
                            }
                        }
                    }
                }
            });
        </script>


    @endif

    <script>
        @if ($vue === 'globales')
        new Chart(document.getElementById('etatChart'), {
            type: 'pie',
            data: {
                labels: ['Actifs', 'Inactifs'],
                datasets: [{
                    data: [{{ $stats['actifs'] }}, {{ $stats['inactifs'] }}],
                    backgroundColor: ['#4caf50', '#f44336']
                }]
            }
        });

        new Chart(document.getElementById('zoneChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($stats['zones']->toArray())) !!},
                datasets: [{
                    label: 'Objets par zone',
                    data: {!! json_encode(array_values($stats['zones']->toArray())) !!},
                    backgroundColor: '#2196f3'
                }]
            }
        });

        new Chart(document.getElementById('moyennesChart'), {
            type: 'bar',
            data: {
                labels: ['Luminosité', 'Température cible'],
                datasets: [{
                    label: 'Valeur moyenne',
                    data: [
                        {{ $stats['moyennes']['luminosite'] ?? 0 }},
                        {{ $stats['moyennes']['temperature'] ?? 0 }}
                    ],
                    backgroundColor: '#ff9800'
                }]
            }
        });
        @elseif ($vue === 'utilisation')
        new Chart(document.getElementById('activiteChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($stats['activiteParJour'])) !!},
                datasets: [{
                    label: 'Nombre d\'objets utilisés',
                    data: {!! json_encode(array_values($stats['activiteParJour'])) !!},
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });

        new Chart(document.getElementById('utilisationChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($stats['utilisationParObjet'])) !!},
                datasets: [{
                    label: 'Utilisation par objet',
                    data: {!! json_encode(array_values($stats['utilisationParObjet'])) !!},
                    backgroundColor: '#9c27b0'
                }]
            }
        });
        @endif
    </script>
    <br><br>
<a href="{{ route('objets.index') }}" style="font-weight: bold;">⬅️ Retour au menu principal</a>

</body>
</html>
