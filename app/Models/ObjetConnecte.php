<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjetConnecte extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_objet_id',
        'batterie',
        'nom',
        'type',
        'etat',
        'luminosite',
        'temperature_actuelle',
        'temperature_cible',
        'volume',
        'position',
        'type',          // Ce champ est rempli automatiquement
        'resolution',
        'champ_vision',
        'puissance',
        'connectivite_s',
        'qualite_air',
        'interphone',
        'etat_portail',
        'zone_id', 
    ];

    public function typeObjet()
    {
        return $this->belongsTo(TypeObjet::class);
    }
    public function zone()
    {
        return $this->belongsTo(\App\Models\Zone::class);
    }

}
