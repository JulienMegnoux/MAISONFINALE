<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un objet connecté</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            margin-bottom: 10px;
        }
        select, input[type="text"], input[type="time"], button {
            padding: 6px;
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            width: 100%;
            max-width: 400px;
        }
        .charts-container {
            display: flex;
            overflow-x: auto;
            gap: 40px;
        }
        .chart-box {
            min-width: 400px;
            flex-shrink: 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Ajouter un objet connecté</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('objets.index') }}">← Retour au menu</a><br><br>

    <form action="{{ route('objets.store') }}" method="POST" id="form-objet">
        @csrf

        <div class="form-group">
            <label>Type d’objet :</label>
            <select name="type_objet_id" id="typeSelect" required>
                <option value="">-- Choisir un type --</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" data-nom="{{ strtolower(\Illuminate\Support\Str::ascii($type->nom)) }}" {{ old('type_objet_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="nom" value="{{ old('nom') }}" required>
        </div>

        <div class="form-group">
            <label>État (actif/inactif) :</label>
            <input type="text" name="etat" value="{{ old('etat') }}" required>
        </div>

        <div class="form-group">
            <label>Zone :</label>
            <select name="zone_id" id="zoneSelect" required>
                <option value="">-- Sélectionner une zone --</option>
                @foreach ($zones as $zone)
                    <option value="{{ $zone->id }}" data-nom="{{ strtolower(\Illuminate\Support\Str::ascii($zone->nom)) }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                        {{ $zone->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="extraFields"></div>

        <button type="submit" id="submitButton">Ajouter</button>
    </form>

    <script>
        function removeAccents(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        const typeSelect = document.getElementById('typeSelect');
        const zoneSelect = document.getElementById('zoneSelect');
        const extraFieldsDiv = document.getElementById('extraFields');
        const submitButton = document.getElementById('submitButton');

        const zoneRules = {
            'portail': ['exterieur'],
            'interphone connecte': ['entree'],
            'volets': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain'],
            'lampe': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain', 'exterieur', 'entree'],
            'thermostat': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain'],
            'alarme': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'entree'],
            'camera de surveillance': ['exterieur'],
            'aspirateur robot': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain'],
            'serrure connectee': ['entree'],
            'capteur de qualite de l air': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain'],
        };

        function updateZoneOptions(typeNom) {
            const zonesOK = zoneRules[typeNom] || [];
            Array.from(zoneSelect.options).forEach(option => {
                if (!option.value) return;
                const zoneNom = removeAccents(option.dataset.nom?.trim().toLowerCase() || '');
                option.hidden = zonesOK.length ? !zonesOK.includes(zoneNom) : false;
            });
        }

        function createInput(label, name, type = "text", value = "", min = "", max = "", step = "1") {
            let inputField = `<div class="form-group"><label>${label} :</label><br>`;
            if (type === "range") {
                inputField += `<input type="range" name="${name}" min="${min}" max="${max}" step="${step}" value="${value}" 
                oninput="document.getElementById('${name}Output').value = this.value">
                <output id="${name}Output">${value}</output>`;
            } else {
                inputField += `<input type="${type}" name="${name}" value="${value}" ${type === 'time' ? 'required' : ''}>`;
            }
            inputField += `</div>`;
            return inputField;
        }

        function updateExtraFields(typeNom) {
            extraFieldsDiv.innerHTML = '';

            switch(typeNom) {
                case 'lampe':
                    extraFieldsDiv.innerHTML += createInput('Luminosité (%)', 'luminosite', 'range', 50, 0, 100);
                    extraFieldsDiv.innerHTML += createInput('Heure de début', 'heure_debut', 'time', '00:00');
                    extraFieldsDiv.innerHTML += createInput('Heure de fin', 'heure_fin', 'time', '00:00');
                    break;
                case 'thermostat':
                    extraFieldsDiv.innerHTML += createInput('Température cible (°C)', 'temperature_cible', 'range', 20, 5, 35);
                    break;
                case 'alarme':
                    extraFieldsDiv.innerHTML += createInput('Volume (%)', 'volume', 'range', 50, 0, 100);
                    break;
                case 'volets':
                    extraFieldsDiv.innerHTML += createInput('Position des volets (%)', 'position', 'range', 0, 0, 100);
                    break;
                default:
                    if (typeNom.includes('portail')) {
                        extraFieldsDiv.innerHTML += `
                        <div class="form-group">
                            <label>État du portail :</label><br>
                            <select name="etat_portail">
                                <option value="ouvert">Ouvert</option>
                                <option value="ferme">Fermé</option>
                            </select>
                        </div>`;
                    }
                    break;
            }
        }

        function handleTypeChange() {
            const selected = typeSelect.options[typeSelect.selectedIndex];
            if (!selected) return;
            const typeNom = removeAccents(selected.text.trim().toLowerCase());

            updateZoneOptions(typeNom);
            updateExtraFields(typeNom);
        }

        document.addEventListener('DOMContentLoaded', () => {
            typeSelect.addEventListener('change', handleTypeChange);
            handleTypeChange();

            document.getElementById('form-objet').addEventListener('submit', function(event) {
                if (!typeSelect.value || !zoneSelect.value) {
                    event.preventDefault();
                    alert('Veuillez choisir un type et une zone avant de soumettre.');
                }
            });
        });
    </script>
</body>
</html>
