<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjetConnecte;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $vue = $request->input('vue', 'quotidien');
        $objets = ObjetConnecte::all();

        $consommations = [];

        foreach ($objets as $objet) {
            $type = strtolower($objet->type);
            $etat = strtolower($objet->etat);
            $actif = $etat === 'actif';

            $consoJour = match ($type) {
                'lampe' => 50,
                'thermostat' => 200,
                'volets' => 30,
                'aspirateur robot' => 300,
                'alarme' => 10,
                'portail' => 25,
                'caméra de surveillance', 'camera de surveillance' => 100,
                'interphone connecté' => 15,
                'capteur de qualité de l\'air', 'capteur de qualite de l air' => 8,
                'serrure connectée', 'serrure connectee' => 5,
                default => 10,
            };

            if (!$actif) {
                $consoJour = 0;
            }

            $consommations[] = [
                'nom' => $objet->nom,
                'type' => $objet->type,
                'etat' => $objet->etat,
                'conso_jour' => $consoJour,
                'conso_semaine' => $consoJour * 7,
            ];
        }

        return view('objets.rapports', compact('consommations', 'vue'));
    }

    public function anomalies()
    {
        $objets = ObjetConnecte::all();
        $anomalies = [];

        foreach ($objets as $objet) {
            $problemes = [];

            $type = strtolower($objet->type);

            // Problème de batterie
            if (!is_null($objet->batterie) && $objet->batterie < 20) {
                $problemes[] = '🔋 Batterie faible (' . $objet->batterie . '%)';
            }

            // Lampe : luminosité excessive
            if ($type === 'lampe' && $objet->luminosite !== null && $objet->luminosite > 90) {
                $problemes[] = '💡 Luminosité trop élevée (' . $objet->luminosite . '%)';
            }

            // Thermostat : température cible trop haute
            if ($type === 'thermostat' && $objet->temperature_cible !== null && $objet->temperature_cible > 26) {
                $problemes[] = '🌡️ Température cible trop élevée (' . $objet->temperature_cible . '°C)';
            }

            // Alarme sans batterie (cohérence)
            if ($type === 'alarme' && $objet->batterie === null) {
                $problemes[] = '⚠️ Donnée de batterie manquante';
            }

            // Capteur de qualité de l’air : valeur nulle ou absente
            if (str_contains($type, 'qualite') && $objet->qualite_air === null) {
                $problemes[] = '🌫️ Donnée de qualité de l’air absente';
            }

            if (!empty($problemes)) {
                $anomalies[] = [
                    'nom' => $objet->nom,
                    'type' => $objet->type,
                    'problemes' => $problemes
                ];
            }
        }

        return view('objets.rapports', ['anomalies' => $anomalies]);
    }
}
