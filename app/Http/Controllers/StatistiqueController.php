<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjetConnecte;

class StatistiqueController extends Controller
{
    public function index(Request $request)
    {
        $vue = $request->input('vue', 'globales');

        $objets = ObjetConnecte::all();

        $stats = [];

        // Statistiques globales
        if ($vue === 'globales') {
            $stats['actifs'] = $objets->where('etat', 'actif')->count();
            $stats['inactifs'] = $objets->where('etat', 'inactif')->count();

            $stats['zones'] = $objets->groupBy(fn ($o) => $o->zone?->nom ?? 'Non défini')
                ->map(fn ($groupe) => count($groupe));

            $luminosites = $objets->pluck('luminosite')->filter();
            $temperatures = $objets->pluck('temperature_cible')->filter();

            $stats['moyennes'] = [
                'luminosite' => $luminosites->count() ? round($luminosites->avg(), 1) : null,
                'temperature' => $temperatures->count() ? round($temperatures->avg(), 1) : null,
            ];
        }

        // Statistiques d'utilisation
        if ($vue === 'utilisation') {
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            $stats['activiteParJour'] = [];

            foreach ($jours as $jour) {
                $stats['activiteParJour'][$jour] = rand(2, 10);
            }

            $stats['objetsModifies'] = $objets->random(min(3, $objets->count()))->pluck('nom')->toArray();

            $stats['utilisationParObjet'] = [];
            foreach ($objets as $objet) {
                $stats['utilisationParObjet'][$objet->nom] = rand(0, 20);
            }
        }
        // Historique simulé des 7 derniers jours
        $historique = [];
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        foreach ($jours as $jour) {
            $historique[] = [
                'jour' => $jour,
                'utilisation' => rand(1, 10), // Nombre aléatoire d'objets utilisés
            ];
        }

        $stats['historique'] = $historique;


        return view('objets.statistiques', compact('stats', 'vue'));
    }
}

