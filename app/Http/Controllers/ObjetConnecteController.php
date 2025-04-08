<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjetConnecte;
use App\Models\TypeObjet;
use App\Models\Zone;

class ObjetConnecteController extends Controller
{

    public function toggleEtat($id)
    {
        $objet = ObjetConnecte::findOrFail($id);

        // On inverse l'état actif/inactif
        $objet->etat = $objet->etat === 'actif' ? 'inactif' : 'actif';

        // Si c’est un portail → on change aussi le champ etat_portail
        if (strtolower($objet->type) === 'portail') {
            $objet->etat_portail = $objet->etat === 'actif' ? 'ouvert' : 'fermé';
        }

        $objet->save();

        return redirect()->back()->with('success', 'État de l\'objet mis à jour.');
    }

    // Fonction utilitaire pour normaliser une chaîne
    private function normalizeString($str)
    {
        return strtolower(trim(iconv('UTF-8', 'ASCII//TRANSLIT', $str)));
    }

    public function index()
    {
        $objets = ObjetConnecte::with('typeObjet', 'zone')->get();
        return view('objets.index', compact('objets'));
    }

    public function create(Request $request)
    {
        $types = \App\Models\TypeObjet::all();
        $zones = \App\Models\Zone::all();
        $typeSelectionne = $request->input('type_objet_id');

        return view('objets.create', compact('types', 'zones', 'typeSelectionne'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_objet_id'         => 'required|exists:types_objets,id',
            'zone_id'               => 'nullable|exists:zones,id',
            'nom'                   => 'required|string|max:255',
            'etat'                  => 'required|string|max:50',

            // Champs conditionnels
            'luminosite'            => 'nullable|integer|min:0|max:100',
            'heure_debut'           => 'nullable|date_format:H:i',
            'heure_fin'             => 'nullable|date_format:H:i',

            'temperature_actuelle'  => 'nullable|numeric|min:5|max:35',
            'temperature_cible'     => 'nullable|numeric|min:5|max:35',

            'volume'                => 'nullable|integer|min:0|max:100',
            'position'              => 'nullable|integer|min:0|max:100',

            'etat_portail'          => 'nullable|in:ouvert,fermé',

            'resolution'            => 'nullable|string|max:100',
            'champ_vision'          => 'nullable|string|max:100',
            'puissance'             => 'nullable|numeric|min:0|max:10000',
            'connectivite_s'        => 'nullable|string|max:100',
            'qualite_air'           => 'nullable|numeric|min:0|max:100',
            'interphone'            => 'nullable|string|max:100',
            'plage_horaire' => 'nullable|string|max:255',]);

        // Ajoute dynamiquement le nom du type (utile pour affichage/filtres)
        $typeObjet = \App\Models\TypeObjet::find($validated['type_objet_id']);
        $validated['type'] = $typeObjet ? $typeObjet->nom : 'inconnu';
        
        if (!isset($validated['batterie'])) {
            $validated['batterie'] = rand(10, 100); // batterie entre 10% et 100%
        }
        // Crée l'objet connecté
        \App\Models\ObjetConnecte::create($validated);
        // Plage horaire enregistrée si présente

        return redirect()->route('objets.index')->with('success', 'Objet ajouté avec succès.');
    }

    public function edit($id)
    {
        $objet = ObjetConnecte::findOrFail($id);
        $types = TypeObjet::all();
        $zones = Zone::all();
        return view('objets.edit', compact('objet', 'types', 'zones'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type_objet_id'         => 'required|exists:types_objets,id',
            'zone_id'               => 'nullable|exists:zones,id',
            'nom'                   => 'required|string|max:255',
            'etat'                  => 'required|string|max:50',
            'luminosite'            => 'nullable|integer|min:0|max:100',
            'temperature_cible'     => 'nullable|numeric|min:5|max:35',
            'volume'                => 'nullable|integer|min:0|max:100',
            'position'              => 'nullable|integer|min:0|max:100',
            'resolution'            => 'nullable|string|max:255',
            'champ_vision'          => 'nullable|string|max:255',
            'puissance'             => 'nullable|numeric',
            'connectivite_s'        => 'nullable|string|max:255',
            'qualite_air'           => 'nullable|numeric',
            'interphone'            => 'nullable|string|max:255',
            'etat_portail'          => 'nullable|string|max:50',
            'plage_horaire'         => 'nullable|string|max:255',
        ]);

        $typeObjet = TypeObjet::find($validated['type_objet_id']);
        $validated['type'] = $typeObjet ? $typeObjet->nom : 'inconnu';

        $objet = ObjetConnecte::findOrFail($id);
        $objet->update($validated);

        return redirect()->route('objets.index')->with('success', 'Objet mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $objet = ObjetConnecte::findOrFail($id);
        $objet->delete();

        return redirect()->route('objets.index')->with('success', 'Objet supprimé.');
    }
}  
function hasDemandeSuppression($objet)
{
        return \App\Models\DemandeSuppression::where('objet_connecte_id', $objet->id)
            ->where('user_id', auth()->id())
            ->exists();
}
