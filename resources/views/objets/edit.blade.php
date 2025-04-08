<!DOCTYPE html>
<html>
<head>
    <title>Modifier un objet connecté</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        label { font-weight: bold; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Modifier un objet connecté</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('objets.index') }}">← Retour au menu</a><br><br><form action="{{ route('objets.update', $objet->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="type_objet_id" value="{{ $objet->type_objet_id }}">

        <label>Type d’objet :</label><br>
        <input type="text" value="{{ $objet->type }}" disabled><br><br>

        <label>Nom :</label><br>
        <input type="text" name="nom" value="{{ old('nom', $objet->nom) }}"><br><br>

        <label>État (actif/inactif) :</label><br>
        <input type="text" name="etat" value="{{ old('etat', $objet->etat) }}"><br><br>

        <label>Zone :</label><br>
        <select name="zone_id" id="zoneSelect">
            <option value="">-- Sélectionner une zone --</option>
            @foreach ($zones as $zone)
                <option value="{{ $zone->id }}" data-nom="{{ strtolower($zone->nom) }}"
                    {{ old('zone_id', $objet->zone_id) == $zone->id ? 'selected' : '' }}>
                    {{ $zone->nom }}
                </option>
            @endforeach
        </select><br><br>

        @php
            $type = strtolower($objet->type);
        @endphp

        @if ($type === 'lampe')
            <label>Luminosité (%) :</label><br>
            <input type="range" name="luminosite" min="0" max="100" step="1" value="{{ old('luminosite', $objet->luminosite ?? 50) }}"
                oninput="document.getElementById('lumOutput').value = this.value">
            <output id="lumOutput">{{ old('luminosite', $objet->luminosite ?? 50) }}</output>%<br><br>

            <label>Plage horaire d’allumage :</label><br>
            De : <input type="time" name="plage_debut" value="{{ old('plage_debut', $objet->plage_debut) }}">
            à <input type="time" name="plage_fin" value="{{ old('plage_fin', $objet->plage_fin) }}"><br><br>

        @elseif ($type === 'thermostat')
            <label>Température cible (°C) :</label><br>
            <input type="range" name="temperature_cible" min="5" max="35" step="0.1"
                value="{{ old('temperature_cible', $objet->temperature_cible ?? 20) }}"
                oninput="document.getElementById('tempOutput').value = this.value">
            <output id="tempOutput">{{ old('temperature_cible', $objet->temperature_cible ?? 20) }}</output>°C<br><br>

        @elseif ($type === 'alarme')
            <label>Volume (%) :</label><br>
            <input type="range" name="volume" min="0" max="100" step="1" value="{{ old('volume', $objet->volume ?? 50) }}"
                oninput="document.getElementById('volOutput').value = this.value">
            <output id="volOutput">{{ old('volume', $objet->volume ?? 50) }}</output>%<br><br>

        @elseif ($type === 'volets')
            <label>Position (0-100%) :</label><br>
            <input type="range" name="position" min="0" max="100" step="1" value="{{ old('position', $objet->position ?? 0) }}"
                oninput="document.getElementById('posOutput').value = this.value">
            <output id="posOutput">{{ old('position', $objet->position ?? 0) }}</output>%<br><br>

        @elseif ($type === 'portail')
            <label>État du portail :</label><br>
            <input type="text" name="etat_portail" value="{{ old('etat_portail', $objet->etat_portail) }}"><br><br>
        @endif

        <button type="submit">Mettre à jour</button>
    </form>

    {{-- Script pour filtre des zones --}}
    <script>
        function removeAccents(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        function updateZones() {
            const zoneSelect = document.getElementById('zoneSelect');
            const typeNom = removeAccents("{{ strtolower($objet->type) }}");

            const zoneRules = {
                'portail': ['exterieur'],
                'interphone connecte': ['entree'],
                'volets': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain'],
                'lampe': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain', 'exterieur', 'entree'],
                'thermostat': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain'],
                'camera de surveillance': ['exterieur'],
                'aspirateur robot': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain'],
                'serrure connectee': ['entree'],
                'capteur de qualite de l air': ['salon', 'chambre 1', 'chambre 2', 'salle a manger', 'salle de bain'],
                'alarme': ['salon', 'chambre 1', 'chambre 2']
            };

            const allowed = zoneRules[typeNom] || [];

            Array.from(zoneSelect.options).forEach(opt => {
                if (!opt.value) return;
                const nom = removeAccents(opt.dataset.nom.toLowerCase());
                opt.hidden = !allowed.includes(nom);
            });
        }

        window.addEventListener('DOMContentLoaded', updateZones);
    </script>
</body>
</html>
